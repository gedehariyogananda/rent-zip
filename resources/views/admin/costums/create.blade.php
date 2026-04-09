@extends('layouts.admin')

@section('content')
<div class="mb-8">
    <div class="flex items-center gap-2 text-sm text-gray-400 mb-3">
        <a href="{{ route('admin.costums.index') }}" class="hover:text-brand-600 transition-colors">Katalog Kostum</a>
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
        <span class="text-gray-600 font-medium">Tambah Kostum</span>
    </div>
    <h1 class="text-3xl font-bold text-brand-800">Tambah Kostum Baru</h1>
</div>

<form action="{{ route('admin.costums.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Left: Photo upload --}}
        <div class="lg:col-span-1">
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-sm font-bold text-gray-700 mb-4">Foto Kostum</h3>

                <div id="photo-preview"
                     class="w-full aspect-square rounded-2xl bg-gray-50 border-2 border-dashed border-gray-200 flex flex-col items-center justify-center overflow-hidden cursor-pointer hover:border-brand-400 transition-colors"
                     onclick="document.getElementById('photo_url').click()">
                    <img id="preview-img" src="" alt="" class="w-full h-full object-cover hidden rounded-2xl">
                    <div id="preview-placeholder" class="flex flex-col items-center text-gray-400 p-6 text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <p class="text-sm font-semibold">Klik untuk upload foto</p>
                        <p class="text-xs mt-1">JPG, PNG, WEBP — maks. 2MB</p>
                    </div>
                </div>

                <input type="file" id="photo_url" name="photo_url" accept="image/*" class="hidden"
                       onchange="previewPhoto(this)">
                @error('photo_url')
                    <p class="mt-2 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>
        </div>

        {{-- Right: Detail form --}}
        <div class="lg:col-span-2 space-y-4">
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 space-y-5">
                <h3 class="text-sm font-bold text-gray-700">Informasi Kostum</h3>

                {{-- Nama --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                        Nama Kostum <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="name" value="{{ old('name') }}"
                           placeholder="contoh: Naruto Uzumaki — Sage Mode"
                           class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-brand-500 @error('name') border-red-400 @enderror">
                    @error('name') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>

                {{-- Sumber --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Sumber / Judul Anime</label>
                    <input type="text" name="source" value="{{ old('source') }}"
                           placeholder="contoh: Naruto Shippuden"
                           class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-brand-500">
                </div>

                {{-- Kategori + Ukuran (2 col) --}}
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                            Kategori <span class="text-red-500">*</span>
                        </label>
                        <select name="category_id"
                                class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-brand-500 @error('category_id') border-red-400 @enderror">
                            <option value="">Pilih Kategori</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                            Ukuran <span class="text-red-500">*</span>
                        </label>
                        <select name="size"
                                class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-brand-500 @error('size') border-red-400 @enderror">
                            @foreach(['XS','S','M','L','XL','XXL'] as $s)
                                <option value="{{ $s }}" {{ old('size') == $s ? 'selected' : '' }}>{{ $s }}</option>
                            @endforeach
                        </select>
                        @error('size') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>
                </div>

                {{-- Stok + Harga (2 col) --}}
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                            Stok <span class="text-red-500">*</span>
                        </label>
                        <input type="number" name="stock" value="{{ old('stock', 1) }}" min="0"
                               class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-brand-500 @error('stock') border-red-400 @enderror">
                        @error('stock') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                            Harga / Hari (Rp) <span class="text-red-500">*</span>
                        </label>
                        <input type="number" name="priceday" value="{{ old('priceday') }}" min="0" step="1000"
                               placeholder="75000"
                               class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-brand-500 @error('priceday') border-red-400 @enderror">
                        @error('priceday') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>
                </div>

                {{-- Deskripsi --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Deskripsi</label>
                    <textarea name="desc" rows="3"
                              placeholder="Deskripsi lengkap kostum, kelengkapan, kondisi, dll."
                              class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-brand-500 resize-none">{{ old('desc') }}</textarea>
                </div>
            </div>

            {{-- Action buttons --}}
            <div class="flex gap-3">
                <button type="submit"
                        class="flex-1 py-3 bg-brand-700 hover:bg-brand-800 text-white rounded-xl text-sm font-bold transition-colors shadow-sm">
                    Simpan Kostum
                </button>
                <a href="{{ route('admin.costums.index') }}"
                   class="flex-1 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl text-sm font-bold transition-colors text-center">
                    Batal
                </a>
            </div>
        </div>

    </div>
</form>

<script>
function previewPhoto(input) {
    const file = input.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = e => {
        document.getElementById('preview-img').src = e.target.result;
        document.getElementById('preview-img').classList.remove('hidden');
        document.getElementById('preview-placeholder').classList.add('hidden');
    };
    reader.readAsDataURL(file);
}
</script>
@endsection
