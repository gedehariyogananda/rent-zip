<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ImageService
{
    /**
     * Upload file ke storage/public/{folder}
     * Mengembalikan path relatif, contoh: "costums/abc123.jpg"
     */
    public function upload(UploadedFile $file, string $folder): string
    {
        return $file->store($folder, 'public');
    }

    /**
     * Hapus file dari storage/public berdasarkan path relatif
     */
    public function delete(?string $path): void
    {
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }

    /**
     * Ganti file lama dengan file baru.
     * Delete path lama → upload baru → kembalikan path baru.
     */
    public function replace(UploadedFile $file, ?string $oldPath, string $folder): string
    {
        $this->delete($oldPath);
        return $this->upload($file, $folder);
    }

    /**
     * Helper: kembalikan public URL dari path relatif
     */
    public function url(?string $path): ?string
    {
        if (!$path) return null;
        return Storage::disk('public')->url($path);
    }
}
