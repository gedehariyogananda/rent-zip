<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\AuthService;
use App\Traits\ApiResponse;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthenticateController extends Controller
{
    use ApiResponse;

    protected AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * API Register
     *
     * Endpoint: POST /api/v1/register
     * Parameters: username, email, password, password_confirmation
     */
    public function register(Request $request)
    {
        $validates = Validator::make($request->all(), [
            "username" => "required|string|max:255",
            "email" => "required|string|email|max:255|unique:users",
            "password" => "required|string|min:8|confirmed",
        ]);

        if ($validates->fails()) {
            return response()->json($validates->errors(), 400);
        }

        try {
            $result = $this->authService->register($request->all());
            $user = $result["user"];

            return $this->apiSuccess(
                [
                    "id" => $user->id,
                    "username" => $user->username,
                    "email" => $user->email,
                    "role" => strtolower($user->role->name ?? "member"),
                    "expires_in" => $result["expires_in"] ?? "5 minutes",
                ],
                201,
                "User registered successfully. OTP sent to your email.",
            );
        } catch (Exception $e) {
            return response()->json(["message" => $e->getMessage()], 400);
        }
    }

    /**
     * API Login - Request OTP
     *
     * Endpoint: POST /api/v1/login
     * Parameters: email, password
     */
    public function login(Request $request)
    {
        $validates = Validator::make($request->all(), [
            "email" => "required|email",
            "password" => "required|string",
        ]);

        if ($validates->fails()) {
            return response()->json($validates->errors(), 400);
        }

        try {
            $result = $this->authService->login($request->all());

            if (isset($result["is_verified"]) && $result["is_verified"]) {
                $user = $result["user"];
                return $this->apiSuccess(
                    [
                        "id" => $user->id,
                        "username" => $user->username,
                        "email" => $user->email,
                        "role" => strtolower($user->role->name ?? "member"),
                        "token" => $result["token"],
                    ],
                    200,
                    "Authentication successfully",
                );
            }

            return $this->apiSuccess(
                [
                    "email" => $result["email"],
                    "expires_in" => $result["expires_in"],
                ],
                200,
                "OTP sent successfully to your email. Please verify to continue.",
            );
        } catch (Exception $e) {
            $statusCode = $e->getCode() > 0 ? $e->getCode() : 500;
            return $this->apiError($statusCode, $e->getMessage());
        }
    }

    /**
     * API Verify OTP - Actual Login
     *
     * Endpoint: POST /api/v1/verify-otp
     * Parameters: email, otp
     */
    public function verifyOtp(Request $request)
    {
        $validates = Validator::make($request->all(), [
            "email" => "required|email",
            "otp" => "required|string|size:6",
        ]);

        if ($validates->fails()) {
            return response()->json($validates->errors(), 400);
        }

        try {
            $result = $this->authService->verifyOtp($request->all());
            $user = $result["user"];

            return $this->apiSuccess(
                [
                    "id" => $user->id,
                    "username" => $user->username,
                    "email" => $user->email,
                    "role" => strtolower($user->role->name ?? "member"),
                    "token" => $result["token"],
                ],
                200,
                "Authentication successfully",
            );
        } catch (Exception $e) {
            $statusCode = $e->getCode() > 0 ? $e->getCode() : 500;
            return $this->apiError($statusCode, $e->getMessage());
        }
    }

    /**
     * API Logout
     *
     * Endpoint: POST /api/v1/logout
     */
    public function logout()
    {
        $this->authService->logout();
        return $this->apiSuccess(null, 200, "Logout successfully");
    }
}
