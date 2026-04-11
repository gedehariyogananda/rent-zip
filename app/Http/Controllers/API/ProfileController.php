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
     * Melengkapi Data Profil User
     * Endpoint: POST /api/v1/profile
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

            // Format URL response
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
