@extends('layouts.admin')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-brand-800 mb-2">Katalog Kostum</h1>
    <p class="text-gray-500">Kelola seluruh koleksi kostum cosplay Jepang.</p>
</div>

<div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
    {{-- Header: filter + tambah --}}
    <div class="p-6 border-b border-gray-50 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <h2 class="text-xl font-bold text-gray-800">Daftar Kostum</h2>

        <div class="flex flex-col sm:flex-row gap-3">
            <form action="{{ route('admin.costums.index') }}" method="GET" class="flex gap-2">
                <input type="text" name="search" value="{{ $filters['search'] ?? '' }}"
                       placeholder="Cari nama kostum..."
                       class="px-4 py-2 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-brand-500">
                <select name="source_anime_category_id" onchange="this.form.submit()"
                        class="px-4 py-2 border border-gray-200 rounded-xl text-sm text-gray-600 focus:outline-none">
                    <option value="">Semua Source Anime</option>
                    @foreach($sourceAnimes as $cat)
                        <option value="{{ $cat->id }}" {{ ($filters['source_anime_category_id'] ?? '') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
                <select name="brand_costum_category_id" onchange="this.form.submit()"
                        class="px-4 py-2 border border-gray-200 rounded-xl text-sm text-gray-600 focus:outline-none">
                    <option value="">Semua Brand</option>
                    @foreach($brands as $cat)
                        <option value="{{ $cat->id }}" {{ ($filters['brand_costum_category_id'] ?? '') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
                <button type="submit"
                        class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl text-sm font-semibold transition-colors">
                    Cari
                </button>
                @if(!empty($filters['search']) || !empty($filters['source_anime_category_id']) || !empty($filters['brand_costum_category_id']))
                    <a href="{{ route('admin.costums.index') }}"
                       class="px-4 py-2 text-sm font-semibold text-gray-500 hover:text-gray-700">Reset</a>
                @endif
            </form>

            <a href="{{ route('admin.costums.create') }}"
               class="flex items-center gap-2 px-5 py-2.5 bg-brand-700 hover:bg-brand-800 text-white rounded-xl text-sm font-bold transition-colors shadow-sm whitespace-nowrap">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Kostum
            </a>
        </div>
    </div>

    <div class="p-6">
        {{-- Table Header --}}
        <div class="grid grid-cols-12 gap-4 pb-4 border-b border-gray-50 text-xs font-bold text-gray-400 uppercase tracking-wider px-4">
            <div class="col-span-1">#</div>
            <div class="col-span-1">FOTO</div>
            <div class="col-span-3">NAMA / ANIME</div>
            <div class="col-span-2">SOURCE / BRAND</div>
            <div class="col-span-1 text-center">SIZE/PAXEL</div>
            <div class="col-span-2">STOK & TERSEWA</div>
            <div class="col-span-1 text-right">HARGA/3 HARI</div>
            <div class="col-span-1 text-right">AKSI</div>
        </div>

        {{-- Table Body --}}
        <div class="space-y-3 mt-4">
            @forelse($costums as $costum)
            @php $no = ($costums->currentPage() - 1) * $costums->perPage() + $loop->iteration; @endphp
            <div class="grid grid-cols-12 gap-4 items-center p-4 bg-gray-50/50 rounded-xl hover:bg-gray-50 transition-colors">

                <div class="col-span-1 text-sm font-bold text-gray-400">{{ $no }}</div>

                <div class="col-span-1">
                    @if($costum->photo_url)
                        <img src="{{ Storage::disk('public')->url($costum->photo_url) }}"
                             alt="{{ $costum->name }}"
                             class="w-10 h-10 rounded-lg object-cover ring-1 ring-gray-200">
                    @else
                        <div class="w-10 h-10 rounded-lg bg-brand-100 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-brand-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    @endif
                </div>

                <div class="col-span-3">
                    <p class="text-sm font-semibold text-gray-800 leading-tight">{{ $costum->name }}</p>
                    @if($costum->name_anime)
                        <p class="text-xs text-gray-400 mt-0.5">{{ $costum->name_anime }}</p>
                    @endif
                </div>

                <div class="col-span-2 flex flex-col items-start gap-1">
                    <span class="inline-flex px-2.5 py-1 rounded-full text-[10px] font-bold bg-brand-50 text-brand-700 uppercase tracking-wider">
                        {{ $costum->sourceAnimeCategory?->name ?? '—' }}
                    </span>
                    <span class="inline-flex px-2.5 py-1 rounded-full text-[10px] font-bold bg-gray-100 text-gray-600 uppercase tracking-wider">
                        {{ $costum->brandCostumCategory?->name ?? '—' }}
                    </span>
                </div>

                <div class="col-span-1 flex flex-col items-center gap-1 text-center">
                    <span class="inline-flex px-2 py-0.5 rounded-lg text-xs font-bold bg-gray-100 text-gray-600">
                        {{ $costum->size }}
                    </span>
                    <span class="text-[10px] text-gray-500 uppercase">{{ $costum->paxel }}</span>
                </div>

                <div class="col-span-2 flex flex-col justify-center pr-4">
                    <div class="flex items-center justify-between text-xs mb-1">
                        <span class="font-bold text-gray-700">{{ $costum->stock }} Max</span>
                        <span class="font-medium text-gray-500">{{ $costum->rented_stock }} Tersewa</span>
                    </div>
                    @php
                        $percentage = $costum->stock > 0 ? min(100, round(($costum->rented_stock / $costum->stock) * 100)) : 0;
                        $barColor = $percentage >= 100 ? 'bg-gray-800' : ($percentage >= 80 ? 'bg-orange-700' : 'bg-brand-600');
                        $bgColor = $percentage >= 100 ? 'bg-gray-200' : 'bg-brand-100';
                    @endphp
                    <div class="w-full h-1.5 {{ $bgColor }} rounded-full overflow-hidden flex mb-1.5">
                        <div class="{{ $barColor }} h-full rounded-full" style="width: {{ $percentage }}%"></div>
                    </div>
                    <div>
                        @if($costum->stock == 0 || $costum->available_stock <= 0)
                            <span class="inline-flex px-2 py-0.5 rounded text-[9px] font-bold bg-gray-200 text-gray-600 uppercase tracking-wider">FULL</span>
                        @elseif($costum->available_stock <= 2)
                            <span class="inline-flex px-2 py-0.5 rounded text-[9px] font-bold bg-orange-100 text-orange-700 uppercase tracking-wider">CLOSING SOON</span>
                        @else
                            <span class="inline-flex px-2 py-0.5 rounded text-[9px] font-bold bg-[#d4edda] text-green-800 uppercase tracking-wider">AVAILABLE</span>
                        @endif
                    </div>
                </div>

                <div class="col-span-1 text-right text-sm font-semibold text-gray-700">
                    Rp {{ number_format($costum->priceday, 0, ',', '.') }}
                </div>

                <div class="col-span-1 flex justify-end relative group">
                    <button class="text-gray-400 hover:text-gray-600 p-1 focus:outline-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z" />
                        </svg>
                    </button>
                    <div class="absolute right-0 top-8 w-32 bg-white rounded-lg shadow-lg border border-gray-100 py-1 z-10 hidden group-hover:block group-focus-within:block">
                        <a href="{{ route('admin.costums.edit', $costum->id) }}"
                           class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Edit</a>
                        <form action="{{ route('admin.costums.destroy', $costum->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    onclick="return confirm('Hapus kostum \'{{ $costum->name }}\'?\nFoto juga akan ikut terhapus.')"
                                    class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                Hapus
                            </button>
                        </form>
                    </div>
                </div>

            </div>
            @empty
            <div class="py-16 text-center">
                <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-gray-100 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                </div>
                <p class="text-gray-500 text-sm font-medium">Belum ada kostum.</p>
                <a href="{{ route('admin.costums.create') }}"
                   class="mt-3 inline-flex items-center text-sm font-semibold text-brand-600 hover:text-brand-800">
                    + Tambah kostum sekarang
                </a>
            </div>
            @endforelse
        </div>

        <x-pagination :paginator="$costums" label="kostum" />
    </div>
</div>
@endsection
