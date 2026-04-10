@extends('layouts.admin')

@section('content')
<div class="max-w-4xl mx-auto py-6">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Edit Profile</h1>
            <p class="text-sm text-gray-500 mt-1">Update your personal information and password.</p>
        </div>
    </div>

    <div class="bg-white shadow-sm rounded-xl border border-gray-100 overflow-hidden">
        <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data" class="p-8">
            @csrf
            @method('PUT')

            <!-- Personal Info Section -->
            <div class="mb-10">
                <h3 class="text-lg font-bold text-gray-800 mb-6 pb-2 border-b border-gray-100">Informasi Pribadi</h3>

                <div class="mb-6 flex flex-col items-start gap-4" x-data="{ photoPreview: null }">
                    <label class="block text-sm font-bold text-gray-700">Photo / Avatar</label>
                    <div class="flex items-center gap-6">
                        <!-- Current Profile Photo -->
                        <div class="w-20 h-20 rounded-2xl overflow-hidden bg-gray-100 border border-gray-200 flex-shrink-0" x-show="!photoPreview">
                            @if($user->avatar_url)
                                <img src="{{ Storage::url($user->avatar_url) }}" alt="{{ $user->username }}" class="w-full h-full object-cover">
                            @else
                                <svg class="w-full h-full text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                            @endif
                        </div>

                        <!-- New Profile Photo Preview -->
                        <div class="w-20 h-20 rounded-2xl overflow-hidden bg-gray-100 border border-gray-200 flex-shrink-0" x-show="photoPreview" style="display: none;">
                            <img x-bind:src="photoPreview" class="w-full h-full object-cover">
                        </div>

                        <div class="flex flex-col">
                            <label for="avatar_url" class="cursor-pointer px-4 py-2 bg-brand-50 text-brand-700 hover:bg-brand-100 rounded-xl text-sm font-bold transition-colors inline-block text-center">
                                Ubah Foto
                                <input id="avatar_url" name="avatar_url" type="file" class="sr-only" accept="image/*"
                                    @change="
                                        const reader = new FileReader();
                                        reader.onload = (e) => { photoPreview = e.target.result; };
                                        reader.readAsDataURL($event.target.files[0]);
                                    "
                                >
                            </label>
                            @error('avatar_url')
                                <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="username" class="block text-sm font-bold text-gray-700 mb-2">Username <span class="text-red-500">*</span></label>
                        <input type="text" name="username" id="username" value="{{ old('username', $user->username) }}" required
                            class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-brand-500">
                        @error('username')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-bold text-gray-700 mb-2">Email Address</label>
                        <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" readonly
                            class="w-full px-4 py-3 bg-gray-100 border border-gray-200 rounded-xl text-sm text-gray-500 cursor-not-allowed">
                        <p class="mt-1 text-xs text-gray-400">*Email tidak dapat diubah</p>
                    </div>

                    <div>
                        <label for="phone" class="block text-sm font-bold text-gray-700 mb-2">Phone</label>
                        <input type="text" name="phone" id="phone" value="{{ old('phone', $user->phone) }}"
                            class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-brand-500">
                        @error('phone')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label for="address" class="block text-sm font-bold text-gray-700 mb-2">Address</label>
                        <textarea id="address" name="address" rows="3"
                            class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 resize-none">{{ old('address', $user->address) }}</textarea>
                        @error('address')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Password Update Section -->
            <div class="mb-10">
                <h3 class="text-lg font-bold text-gray-800 mb-2 pb-2 border-b border-gray-100">Update Password</h3>
                <p class="text-sm text-gray-500 mb-6">Kosongkan jika Anda tidak ingin mengubah password.</p>

                <div class="max-w-md">
                    <label for="password" class="block text-sm font-bold text-gray-700 mb-2">New Password</label>
                    <input type="password" name="password" id="password"
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-brand-500">
                    @error('password')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="pt-6 border-t border-gray-100 flex items-center justify-end gap-4">
                <a href="{{ route('admin.dashboard') }}" class="px-6 py-3 text-sm font-bold text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-xl transition-colors">
                    Batal
                </a>
                <button type="submit" class="flex items-center px-8 py-3 bg-brand-700 hover:bg-brand-800 text-white rounded-xl text-sm font-bold transition-colors shadow-sm">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<script src="//unpkg.com/alpinejs" defer></script>
@endsection
