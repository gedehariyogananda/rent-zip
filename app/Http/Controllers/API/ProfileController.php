<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\ProfileService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Exception;

class ProfileController extends Controller
{
    protected ProfileService $profileService;

    public function __construct(ProfileService $profileService)
    {
        $this->profileService = $profileService;
    }

    /**
     * Mengambil Data Profil Login Saat Ini
     * Endpoint: GET /api/v1/profile
     */
    public function show()
    {
        try {
            $user = Auth::guard("api")->user()->load("profile");

            if ($user->avatar_url) {
                $user->avatar_url = url("storage/" . $user->avatar_url);
            }

            if ($user->profile) {
                if ($user->profile->ktp_url) {
                    $user->profile->ktp_url = url(
                        "storage/" . $user->profile->ktp_url,
                    );
                }
                if ($user->profile->photo_with_nik) {
                    $user->profile->photo_with_nik = url(
                        "storage/" . $user->profile->photo_with_nik,
                    );
                }
            }

            return response()->json(
                [
                    "success" => true,
                    "message" => "Data profil berhasil dimuat",
                    "data" => $user,
                ],
                200,
            );
        } catch (Exception $e) {
            return response()->json(
                [
                    "success" => false,
                    "message" => "Gagal memuat profil: " . $e->getMessage(),
                ],
                500,
            );
        }
    }

    /**
     * Melengkapi Data Profil User (Checkout)
     * Endpoint: POST /api/v1/profile/checkout
     * (Untuk Backward Compatibility Checkout/Order)
     */
    public function update(Request $request)
    {
        try {
            $request->validate([
                "nik" => "required|string|max:16",
                "address" => "required|string",
                "no_darurat" => "required|string|max:15",
                "ktp_photo" => "nullable|image|mimes:jpeg,png,jpg|max:2048",
                "photo_with_nik" =>
                    "nullable|image|mimes:jpeg,png,jpg|max:2048",
            ]);

            $user = Auth::guard("api")->user();

            $result = $this->profileService->updateProfile(
                $user,
                $request->only(["nik", "address", "no_darurat"]),
                $request->file("ktp_photo"),
                $request->file("photo_with_nik"),
            );

            $profile = $result["profile"];

            $profile->ktp_url = $profile->ktp_url
                ? url("storage/" . $profile->ktp_url)
                : null;
            $profile->photo_with_nik = $profile->photo_with_nik
                ? url("storage/" . $profile->photo_with_nik)
                : null;

            return response()->json(
                [
                    "success" => true,
                    "message" => "Profil berhasil dilengkapi",
                    "data" => [
                        "user" => $result["user"],
                        "profile" => $profile,
                    ],
                ],
                200,
            );
        } catch (Exception $e) {
            return response()->json(
                [
                    "success" => false,
                    "message" => "Gagal melengkapi profil: " . $e->getMessage(),
                ],
                500,
            );
        }
    }

    /**
     * Update Seluruh Data Profil User (Pengaturan Akun)
     * Endpoint: POST /api/v1/profile/update
     */
    public function updateFull(Request $request)
    {
        try {
            $user = Auth::guard("api")->user();

            $request->validate([
                "username" => "nullable|string|max:255",
                "email" =>
                    "nullable|email|max:255|unique:users,email," . $user->id,
                "phone" => "nullable|string|max:20",
                "address" => "nullable|string",
                "nik" => "nullable|string|max:16",
                "no_darurat" => "nullable|string|max:15",
                "avatar" => "nullable|image|mimes:jpeg,png,jpg|max:2048",
                "ktp_photo" => "nullable|image|mimes:jpeg,png,jpg|max:2048",
                "photo_with_nik" =>
                    "nullable|image|mimes:jpeg,png,jpg|max:2048",
            ]);

            $userData = $request->only([
                "username",
                "email",
                "phone",
                "address",
            ]);
            $profileData = $request->only(["nik", "no_darurat"]);

            $result = $this->profileService->updateFullProfile(
                $user,
                $userData,
                $profileData,
                $request->file("avatar"),
                $request->file("ktp_photo"),
                $request->file("photo_with_nik"),
            );

            $updatedUser = $result["user"];
            $profile = $result["profile"];

            if ($updatedUser->avatar_url) {
                $updatedUser->avatar_url = url(
                    "storage/" . $updatedUser->avatar_url,
                );
            }
            if ($profile && $profile->ktp_url) {
                $profile->ktp_url = url("storage/" . $profile->ktp_url);
            }
            if ($profile && $profile->photo_with_nik) {
                $profile->photo_with_nik = url(
                    "storage/" . $profile->photo_with_nik,
                );
            }

            return response()->json(
                [
                    "success" => true,
                    "message" => "Profil berhasil diperbarui",
                    "data" => [
                        "user" => $updatedUser,
                        "profile" => $profile,
                    ],
                ],
                200,
            );
        } catch (Exception $e) {
            return response()->json(
                [
                    "success" => false,
                    "message" =>
                        "Gagal memperbarui profil: " . $e->getMessage(),
                ],
                500,
            );
        }
    }

    /**
     * Ubah Password User
     * Endpoint: POST /api/v1/profile/change-password
     */
    public function changePassword(Request $request)
    {
        try {
            $request->validate([
                "current_password" => "required|string",
                "new_password" => "required|string|min:6|confirmed", // wajib ada field 'new_password_confirmation' di FE
            ]);

            $user = Auth::guard("api")->user();

            $this->profileService->changePassword(
                $user,
                $request->current_password,
                $request->new_password,
            );

            return response()->json(
                [
                    "success" => true,
                    "message" => "Password berhasil diubah",
                ],
                200,
            );
        } catch (Exception $e) {
            $code =
                $e->getCode() >= 400 && $e->getCode() < 600
                    ? $e->getCode()
                    : 500;
            return response()->json(
                [
                    "success" => false,
                    "message" => "Gagal mengubah password: " . $e->getMessage(),
                ],
                $code,
            );
        }
    }

    /**
     * Mengecek Status Kelengkapan Profil
     * Endpoint: GET /api/v1/profile/check
     */
    public function check()
    {
        try {
            $user = Auth::guard("api")->user();
            $profile = $user->profile;

            $isVerified =
                !empty($user->address) &&
                $profile &&
                !empty($profile->nik) &&
                !empty($profile->ktp_url) &&
                !empty($profile->photo_with_nik) &&
                !empty($profile->no_darurat);

            return response()->json(
                [
                    "success" => true,
                    "message" => "Status profil berhasil dicek",
                    "data" => [
                        "is_verified" => (bool) $isVerified,
                    ],
                ],
                200,
            );
        } catch (Exception $e) {
            return response()->json(
                [
                    "success" => false,
                    "message" => "Gagal mengecek profil: " . $e->getMessage(),
                ],
                500,
            );
        }
    }
}
