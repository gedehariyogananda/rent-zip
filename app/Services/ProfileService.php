<?php

namespace App\Services;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class ProfileService
{
    /**
     * Update or create user profile and address
     */
    public function updateProfile(
        User $user,
        array $data,
        $ktpFile = null,
        $photoNikFile = null,
    ) {
        DB::beginTransaction();
        try {
            // Update address in users table
            if (isset($data["address"])) {
                $user->address = $data["address"];
                $user->save();
            }

            // Prepare profile data
            $profileData = [];
            if (isset($data["nik"])) {
                $profileData["nik"] = $data["nik"];
            }
            if (isset($data["no_darurat"])) {
                $profileData["no_darurat"] = $data["no_darurat"];
            }

            // Handle Upload Foto KTP
            if ($ktpFile) {
                $pathKtp = $ktpFile->store("profiles/ktp", "public");
                $profileData["ktp_url"] = $pathKtp;
            }

            // Handle Upload Foto dengan NIK
            if ($photoNikFile) {
                $pathPhotoNik = $photoNikFile->store(
                    "profiles/photo_nik",
                    "public",
                );
                $profileData["photo_with_nik"] = $pathPhotoNik;
            }

            // Update atau Create data di tabel profiles
            $profile = Profile::updateOrCreate(
                ["user_id" => $user->id],
                $profileData,
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
}
