<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    protected ImageService $imageService;

    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }

    public function edit()
    {
        $user = auth()->user();
        return view("admin.profile.edit", compact("user"));
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $data = $request->validate([
            "username" => "required|string|max:255",
            "phone" => "nullable|string|max:20",
            "address" => "nullable|string",
            "password" => "nullable|string|min:6",
            "avatar_url" => "nullable|image|mimes:jpg,jpeg,png,webp|max:2048",
        ]);

        if ($request->hasFile("avatar_url")) {
            $data["avatar_url"] = $this->imageService->replace(
                $request->file("avatar_url"),
                $user->avatar_url,
                "avatars",
            );
        } else {
            unset($data["avatar_url"]);
        }

        if (!empty($data["password"])) {
            $data["password"] = Hash::make($data["password"]);
        } else {
            unset($data["password"]);
        }

        $user->update($data);

        return redirect()
            ->route("admin.profile.edit")
            ->with("success", "Profile updated successfully.");
    }
}
