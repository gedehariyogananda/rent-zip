<?php

namespace App\Services;

use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use App\Mail\OtpMail;
use Carbon\Carbon;
use Exception;

class AuthService
{
    protected UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function register(array $data)
    {
        $data["password"] = Hash::make($data["password"]);
        $data["role_id"] = 2; // Member
        $data["email_verified_at"] = null; // Menunggu OTP
        $data["is_active"] = true;

        // Generate OTP
        $otp = str_pad(random_int(0, 999999), 6, "0", STR_PAD_LEFT);
        $data["otp"] = $otp;
        $data["otp_expires_at"] = Carbon::now()->addMinutes(5);

        $user = $this->userRepository->store($data);

        // Send Email OTP
        Mail::to($user->email)->send(new OtpMail($otp, $user));

        return [
            "user" => $user,
            "token" => null,
            "email" => $user->email,
            "expires_in" => "5 minutes",
        ];
    }

    public function login(array $credentials)
    {
        $user = $this->userRepository->findByEmail($credentials["email"]);

        if (!$user) {
            throw new Exception("User not found", 404);
        }

        if (!$user->is_active) {
            throw new Exception("Account is not active", 403);
        }

        if (!Hash::check($credentials["password"], $user->password)) {
            throw new Exception("Invalid credentials", 401);
        }

        // Jika email sudah diverifikasi sebelumnya ATAU user adalah Admin, langsung login dan berikan token
        if ($user->email_verified_at !== null || $user->role_id == 1) {
            $token = Auth::guard("api")->login($user);

            return [
                "user" => $user,
                "token" => $token,
                "is_verified" => true,
            ];
        }

        // Generate 6 digit OTP
        $otp = str_pad(random_int(0, 999999), 6, "0", STR_PAD_LEFT);

        // Update user with OTP
        $this->userRepository->update(
            [
                "otp" => $otp,
                "otp_expires_at" => Carbon::now()->addMinutes(5),
            ],
            $user->id,
        );

        // Send Email
        Mail::to($user->email)->send(new OtpMail($otp, $user));

        return [
            "email" => $user->email,
            "expires_in" => "5 minutes",
            "is_verified" => false,
        ];
    }

    public function verifyOtp(array $data)
    {
        $user = $this->userRepository->findByEmail($data["email"]);

        if (!$user) {
            throw new Exception("User not found", 404);
        }

        if (!$user->otp || $user->otp !== $data["otp"]) {
            throw new Exception("Invalid OTP", 401);
        }

        if (Carbon::now()->isAfter($user->otp_expires_at)) {
            throw new Exception("OTP has expired. Please login again.", 401);
        }

        // OTP is valid, clear it
        $updateData = [
            "otp" => null,
            "otp_expires_at" => null,
        ];

        if (!$user->email_verified_at) {
            $updateData["email_verified_at"] = now();
        }

        $user = $this->userRepository->update($updateData, $user->id);

        // Generate Token
        $token = Auth::guard("api")->login($user);

        return [
            "user" => $user,
            "token" => $token,
        ];
    }

    public function logout()
    {
        Auth::guard("api")->logout();
        return true;
    }
}
