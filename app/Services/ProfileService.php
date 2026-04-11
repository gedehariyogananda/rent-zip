<?php

namespace App\Services;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Exception;

class ProfileService
{
    /**
     * Update user profile completely (User & Profile tables)
     */
    public function updateFullProfile(
        User $user,
        array $userData,
        array $profileData,
        $avatarFile = null,
        $ktpFile = null,
        $photoNikFile = null,
    ) {
        DB::beginTransaction();
        try {
            // 1. Update User Table Data
            if (isset($userData["username"])) {
                $user->username = $userData["username"];
            }
            if (isset($userData["email"])) {
                $user->email = $userData["email"];
            }
            if (isset($userData["phone"])) {
                $user->phone = $userData["phone"];
            }
            if (isset($userData["address"])) {
                $user->address = $userData["address"];
            }

            // Handle Avatar Upload
            if ($avatarFile) {
                // Delete old avatar if exists
                if (
                    $user->avatar_url &&
                    Storage::disk("public")->exists($user->avatar_url)
                ) {
                    Storage::disk("public")->delete($user->avatar_url);
                }
                $pathAvatar = $avatarFile->store("users/avatar", "public");
                $user->avatar_url = $pathAvatar;
            }

            $user->save();

            // 2. Prepare and Update Profile Table Data
            $profileUpdateData = [];
            if (isset($profileData["nik"])) {
                $profileUpdateData["nik"] = $profileData["nik"];
            }
            if (isset($profileData["no_darurat"])) {
                $profileUpdateData["no_darurat"] = $profileData["no_darurat"];
            }

            $profile = Profile::firstOrNew(["user_id" => $user->id]);

            // Handle Upload Foto KTP
            if ($ktpFile) {
                if (
                    $profile->ktp_url &&
                    Storage::disk("public")->exists($profile->ktp_url)
                ) {
                    Storage::disk("public")->delete($profile->ktp_url);
                }
                $pathKtp = $ktpFile->store("profiles/ktp", "public");
                $profileUpdateData["ktp_url"] = $pathKtp;
            }

            // Handle Upload Foto dengan NIK
            if ($photoNikFile) {
                if (
                    $profile->photo_with_nik &&
                    Storage::disk("public")->exists($profile->photo_with_nik)
                ) {
                    Storage::disk("public")->delete($profile->photo_with_nik);
                }
                $pathPhotoNik = $photoNikFile->store(
                    "profiles/photo_nik",
                    "public",
                );
                $profileUpdateData["photo_with_nik"] = $pathPhotoNik;
            }

            // Update or Create Profile
            $profile = Profile::updateOrCreate(
                ["user_id" => $user->id],
                $profileUpdateData,
            );

            DB::commit();

            return [
                "user" => $user,
                "profile" => $profile,
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Change User Password
     */
    public function changePassword(User $user, $currentPassword, $newPassword)
    {
        if (!Hash::check($currentPassword, $user->password)) {
            throw new Exception(
                "Password lama (Current Password) tidak sesuai.",
                400,
            );
        }

        $user->password = Hash::make($newPassword);
        $user->save();

        return true;
    }

    /**
     * Backward compatibility for Order/Checkout logic
     */
    public function updateProfile(
        User $user,
        array $data,
        $ktpFile = null,
        $photoNikFile = null,
    ) {
        return $this->updateFullProfile(
            $user,
            ["address" => $data["address"] ?? null],
            [
                "nik" => $data["nik"] ?? null,
                "no_darurat" => $data["no_darurat"] ?? null,
            ],
            null, // No avatar from checkout
            $ktpFile,
            $photoNikFile,
        );
    }
}
