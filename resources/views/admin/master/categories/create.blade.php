@extends('layouts.admin')

@section('content')
<div class="mb-8">
    <div class="flex items-center gap-2 text-sm text-gray-400 mb-3">
        <a href="{{ route('admin.master.categories.index', ['type' => $type]) }}" class="hover:text-brand-600 transition-colors">
            {{ $type === 'costum' ? 'Kategori Kostum' : ($type === 'pengeluaran' ? 'Kategori Pengeluaran' : 'Kategori Pengurangan Stok') }}
        </a>
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
        <span class="text-gray-600 font-medium">Tambah Kategori</span>
    </div>
    <h1 class="text-3xl font-bold text-brand-800">Tambah Kategori Baru</h1>
</div>

<div class="max-w-lg">
    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8">
        <form action="{{ route('admin.master.categories.store') }}" method="POST" class="space-y-6">
            @csrf

            {{-- Type (hidden from query, tapi tetap ada di form) --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Tipe Kategori</label>
                <div class="flex gap-3">
                    <label class="flex items-center gap-2 px-4 py-3 rounded-xl border-2 cursor-pointer transition-colors
                                  {{ $type === 'costum' ? 'border-brand-600 bg-brand-50' : 'border-gray-200 hover:border-gray-300' }}">
                        <input type="radio" name="type" value="costum"
                               {{ $type === 'costum' ? 'checked' : '' }}
                               class="text-brand-600 focus:ring-brand-500">
                        <span class="text-sm font-semibold text-gray-700">Kostum</span>
                    </label>
                    <label class="flex items-center gap-2 px-4 py-3 rounded-xl border-2 cursor-pointer transition-colors
                                  {{ $type === 'pengeluaran' ? 'border-orange-500 bg-orange-50' : 'border-gray-200 hover:border-gray-300' }}">
                        <input type="radio" name="type" value="pengeluaran"
                               {{ $type === 'pengeluaran' ? 'checked' : '' }}
                               class="text-orange-500 focus:ring-orange-400">
                        <span class="text-sm font-semibold text-gray-700">Pengeluaran</span>
                    </label>
                    <label class="flex items-center gap-2 px-4 py-3 rounded-xl border-2 cursor-pointer transition-colors
                                  {{ $type === 'maintenance' ? 'border-red-500 bg-red-50' : 'border-gray-200 hover:border-gray-300' }}">
                        <input type="radio" name="type" value="maintenance"
                               {{ $type === 'maintenance' ? 'checked' : '' }}
                               class="text-red-500 focus:ring-red-400">
                        <span class="text-sm font-semibold text-gray-700">Pengurangan Stok</span>
                    </label>
                </div>
                @error('type')
                    <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Nama --}}
            <div>
                <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                    Nama Kategori <span class="text-red-500">*</span>
                </label>
                <input type="text" id="name" name="name" value="{{ old('name') }}"
                       placeholder="{{ $type === 'costum' ? 'contoh: Anime Shounen' : ($type === 'pengeluaran' ? 'contoh: Beli Detergen' : 'contoh: Kostum Hilang/Rusak') }}"
                       class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent
                              @error('name') border-red-400 @enderror">
                @error('name')
                    <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex gap-3 pt-2">
                <button type="submit"
                        class="flex-1 py-3 bg-brand-700 hover:bg-brand-800 text-white rounded-xl text-sm font-bold transition-colors shadow-sm">
                    Simpan Kategori
                </button>
                <a href="{{ route('admin.master.categories.index', ['type' => $type]) }}"
                   class="flex-1 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl text-sm font-bold transition-colors text-center">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
