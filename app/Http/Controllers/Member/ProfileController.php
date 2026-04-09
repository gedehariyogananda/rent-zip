<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Services\ProfileService;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    protected ProfileService $profileService;

    public function __construct(ProfileService $profileService)
    {
        $this->profileService = $profileService;
    }

    public function show()
    {
        $profile = $this->profileService->findByUserId(auth()->id());
        return view('member.profile.show', compact('profile'));
    }

    public function edit()
    {
        $profile = $this->profileService->findByUserId(auth()->id());
        return view('member.profile.edit', compact('profile'));
    }

    public function update(Request $request)
    {
        // TODO: implement
        return redirect()->route('member.profile.show');
    }
}
