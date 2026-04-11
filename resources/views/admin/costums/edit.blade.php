@extends('layouts.admin')

@section('content')
<div class="mb-8">
    <div class="flex items-center gap-2 text-sm text-gray-400 mb-3">
        <a href="{{ route('admin.costums.index') }}" class="hover:text-brand-600 transition-colors">Katalog Kostum</a>
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
        <span class="text-gray-600 font-medium">Edit Kostum</span>
    </div>
    <h1 class="text-3xl font-bold text-brand-800">Edit Kostum</h1>
</div>

<form action="{{ route('admin.costums.update', $costum->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Left: Photo --}}
        <div class="lg:col-span-1">
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-sm font-bold text-gray-700 mb-4">Foto Kostum</h3>

                <div id="photo-preview"
                     class="w-full aspect-square rounded-2xl bg-gray-50 border-2 border-dashed border-gray-200 flex flex-col items-center justify-center overflow-hidden cursor-pointer hover:border-brand-400 transition-colors"
                     onclick="document.getElementById('photo_url').click()">

                    @if($costum->photo_url)
                        <img id="preview-img"
                             src="{{ Storage::disk('public')->url($costum->photo_url) }}"
                             alt="{{ $costum->name }}"
                             class="w-full h-full object-cover rounded-2xl">
                        <div id="preview-placeholder" class="hidden"></div>
                    @else
                        <img id="preview-img" src="" alt="" class="w-full h-full object-cover hidden rounded-2xl">
                        <div id="preview-placeholder" class="flex flex-col items-center text-gray-400 p-6 text-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <p class="text-sm font-semibold">Klik untuk upload foto</p>
                            <p class="text-xs mt-1">JPG, PNG, WEBP — maks. 2MB</p>
                        </div>
                    @endif
                </div>

                @if($costum->photo_url)
                    <p class="mt-2 text-xs text-gray-400 text-center">Klik foto untuk mengganti</p>
                @endif

                <input type="file" id="photo_url" name="photo_url" accept="image/*" class="hidden"
                       onchange="previewPhoto(this)">
                @error('photo_url')
                    <p class="mt-2 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>
        </div>

        {{-- Right: Detail --}}
        <div class="lg:col-span-2 space-y-4">
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 space-y-5">
                <h3 class="text-sm font-bold text-gray-700">Informasi Kostum</h3>

                {{-- Nama --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                        Nama Kostum <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="name" value="{{ old('name', $costum->name) }}"
                           class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-brand-500 @error('name') border-red-400 @enderror">
                    @error('name') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>

                {{-- Name Anime --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                        Nama Anime <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="name_anime" value="{{ old('name_anime', $costum->name_anime) }}"
                           class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-brand-500 @error('name_anime') border-red-400 @enderror">
                    @error('name_anime') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>

                {{-- Nama Cosplayer --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                        Nama Cosplayer (Opsional)
                    </label>
                    <input type="text" name="nama_cosplayer" value="{{ old('nama_cosplayer', $costum->nama_cosplayer) }}"
                           placeholder="contoh: Hakken"
                           class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-brand-500 @error('nama_cosplayer') border-red-400 @enderror">
                    @error('nama_cosplayer') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>

                {{-- Kategori Source & Brand --}}
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                            Source Anime Category <span class="text-red-500">*</span>
                        </label>
                        <select name="source_anime_category_id"
                                class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-brand-500 @error('source_anime_category_id') border-red-400 @enderror">
                            <option value="">Pilih Source Anime</option>
                            @foreach($sourceAnimes as $cat)
                                <option value="{{ $cat->id }}" {{ old('source_anime_category_id', $costum->source_anime_category_id) == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('source_anime_category_id') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                            Brand Costum Category <span class="text-red-500">*</span>
                        </label>
                        <select name="brand_costum_category_id"
                                class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-brand-500 @error('brand_costum_category_id') border-red-400 @enderror">
                            <option value="">Pilih Brand</option>
                            @foreach($brands as $cat)
                                <option value="{{ $cat->id }}" {{ old('brand_costum_category_id', $costum->brand_costum_category_id) == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('brand_costum_category_id') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>
                </div>

                {{-- Ukuran, Paxel, Berat J&T --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                            Ukuran <span class="text-red-500">*</span>
                        </label>
                        <select name="size"
                                class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-brand-500 @error('size') border-red-400 @enderror">
                            @foreach(['XS','S','M','L','XL','XXL'] as $s)
                                <option value="{{ $s }}" {{ old('size', $costum->size) == $s ? 'selected' : '' }}>{{ $s }}</option>
                            @endforeach
                        </select>
                        @error('size') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                            Paxel Box Size <span class="text-red-500">*</span>
                        </label>
                        <select name="paxel"
                                class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-brand-500 @error('paxel') border-red-400 @enderror">
                            @foreach(['small','medium','large','custom'] as $p)
                                <option value="{{ $p }}" {{ old('paxel', $costum->paxel) == $p ? 'selected' : '' }}>{{ ucfirst($p) }}</option>
                            @endforeach
                        </select>
                        @error('paxel') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                            Berat J&T (Kg) <span class="text-red-500">*</span>
                        </label>
                        <input type="number" name="berat_jnt" value="{{ old('berat_jnt', $costum->berat_jnt) }}" min="0" step="0.1"
                               class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-brand-500 @error('berat_jnt') border-red-400 @enderror">
                        @error('berat_jnt') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>
                </div>

                {{-- Stok + Harga --}}
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5 flex justify-between items-center">
                            <span>Stok</span>
                            <span class="text-[10px] font-normal text-gray-500 bg-gray-100 px-2 py-0.5 rounded">Edit di Manajemen Stok</span>
                        </label>
                        <input type="number" name="stock" value="{{ old('stock', $costum->stock) }}" readonly
                               class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm text-gray-500 cursor-not-allowed focus:outline-none">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                            Harga Sewa / 3 Hari (Rp) <span class="text-red-500">*</span>
                        </label>
                        <input type="number" name="priceday" value="{{ old('priceday', $costum->priceday) }}" min="0" step="1000"
                               class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-brand-500 @error('priceday') border-red-400 @enderror">
                        @error('priceday') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>
                </div>

                {{-- Deskripsi --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Deskripsi</label>
                    <textarea name="desc" rows="3"
                              class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-brand-500 resize-none">{{ old('desc', $costum->desc) }}</textarea>
                </div>

                {{-- Lokasi --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Lokasi</label>
                    <input type="text" name="lokasi" value="{{ old('lokasi', $costum->lokasi) }}"
                           placeholder="contoh: Mojokerto, Surabaya (Bisa input lebih dari satu lokasi)"
                           class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-brand-500 @error('lokasi') border-red-400 @enderror">
                    @error('lokasi') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="flex gap-3">
                <button type="submit"
                        class="flex-1 py-3 bg-brand-700 hover:bg-brand-800 text-white rounded-xl text-sm font-bold transition-colors shadow-sm">
                    Simpan Perubahan
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
