@extends('layouts.admin')

@section('content')
<div class="mb-8 flex items-center gap-4">
    <a href="{{ route('admin.users.index') }}" class="w-10 h-10 bg-white rounded-xl flex items-center justify-center text-gray-500 hover:text-brand-700 hover:bg-brand-50 transition-colors shadow-sm border border-gray-100">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
        </svg>
    </a>
    <div>
        <h1 class="text-3xl font-bold text-gray-800 mb-1">Tambah Pengguna Baru</h1>
        <p class="text-sm text-gray-500">Isi formulir di bawah ini untuk menambahkan pengguna ke dalam sistem.</p>
    </div>
</div>

<div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden max-w-3xl">
    <form action="{{ route('admin.users.store') }}" method="POST" class="p-8">
        @csrf

        <div class="space-y-6">
            {{-- Username --}}
            <div>
                <label for="username" class="block text-sm font-semibold text-gray-700 mb-2">Username</label>
                <div class="relative">
                    <input type="text"
                           id="username"
                           name="username"
                           value="{{ old('username') }}"
                           class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-brand-500 focus:border-brand-500 transition-all text-sm @error('username') border-red-500 focus:ring-red-500 @enderror"
                           placeholder="Masukkan username pengguna"
                           required>
                </div>
                @error('username')
                    <p class="mt-2 text-sm text-red-500 flex items-center gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Email --}}
            <div>
                <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
                <div class="relative">
                    <input type="email"
                           id="email"
                           name="email"
                           value="{{ old('email') }}"
                           class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-brand-500 focus:border-brand-500 transition-all text-sm @error('email') border-red-500 focus:ring-red-500 @enderror"
                           placeholder="Masukkan alamat email"
                           required>
                </div>
                @error('email')
                    <p class="mt-2 text-sm text-red-500 flex items-center gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Password --}}
            <div>
                <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">Password</label>
                <div class="relative">
                    <input type="password"
                           id="password"
                           name="password"
                           class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-brand-500 focus:border-brand-500 transition-all text-sm @error('password') border-red-500 focus:ring-red-500 @enderror"
                           placeholder="Masukkan password (min. 8 karakter)"
                           required>
                </div>
                @error('password')
                    <p class="mt-2 text-sm text-red-500 flex items-center gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Phone --}}
            <div>
                <label for="phone" class="block text-sm font-semibold text-gray-700 mb-2">Nomor Telepon</label>
                <div class="relative">
                    <input type="text"
                           id="phone"
                           name="phone"
                           value="{{ old('phone') }}"
                           class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-brand-500 focus:border-brand-500 transition-all text-sm @error('phone') border-red-500 focus:ring-red-500 @enderror"
                           placeholder="Masukkan nomor telepon pengguna">
                </div>
                @error('phone')
                    <p class="mt-2 text-sm text-red-500 flex items-center gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Address --}}
            <div>
                <label for="address" class="block text-sm font-semibold text-gray-700 mb-2">Alamat</label>
                <div class="relative">
                    <textarea id="address"
                              name="address"
                              rows="3"
                              class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-brand-500 focus:border-brand-500 transition-all text-sm @error('address') border-red-500 focus:ring-red-500 @enderror"
                              placeholder="Masukkan alamat pengguna">{{ old('address') }}</textarea>
                </div>
                @error('address')
                    <p class="mt-2 text-sm text-red-500 flex items-center gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Role --}}
            <div>
                <label for="role_id" class="block text-sm font-semibold text-gray-700 mb-2">Role Pengguna</label>
                <div class="relative">
                    <select id="role_id"
                            name="role_id"
                            class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-brand-500 focus:border-brand-500 transition-all text-sm appearance-none @error('role_id') border-red-500 focus:ring-red-500 @enderror"
                            required>
                        <option value="" disabled selected>Pilih Role</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>
                                {{ ucfirst($role->name) }}
                            </option>
                        @endforeach
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-gray-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>
                @error('role_id')
                    <p class="mt-2 text-sm text-red-500 flex items-center gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>
        </div>

        <div class="mt-8 pt-6 border-t border-gray-100 flex items-center justify-end gap-3">
            <a href="{{ route('admin.users.index') }}"
               class="px-6 py-2.5 text-sm font-semibold text-gray-600 hover:bg-gray-50 rounded-xl transition-colors">
                Batal
            </a>
            <button type="submit"
                    class="px-6 py-2.5 text-sm font-semibold text-white bg-brand-700 hover:bg-brand-800 rounded-xl shadow-sm transition-colors flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                </svg>
                Simpan Pengguna
            </button>
        </div>
    </form>
</div>
@endsection
