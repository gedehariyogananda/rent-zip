@extends('layouts.member')

@section('title', 'Cari Kostum - ' . config('app.name'))

@section('content')
<div class="space-y-8">

    {{-- Page Header --}}
    <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 flex flex-col md:flex-row justify-between items-center gap-4">
        <div>
            <h2 class="text-2xl font-bold text-[#5c6e46]">Katalog Kostum</h2>
            <p class="text-sm text-gray-500">Temukan kostum karakter favoritmu di sini</p>
        </div>

        {{-- Search / Filter Form --}}
        <form action="{{ route('member.costums.index') }}" method="GET" class="flex flex-wrap gap-3 w-full md:w-auto">
            <select name="source_anime_category_id" class="bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-[#859873] focus:border-[#859873] block p-2.5">
                <option value="">Semua Anime</option>
                @foreach($sourceCategories as $category)
                    <option value="{{ $category->id }}" {{ request('source_anime_category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>

            <select name="brand_costum_category_id" class="bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-[#859873] focus:border-[#859873] block p-2.5">
                <option value="">Semua Brand</option>
                @foreach($brandCategories as $category)
                    <option value="{{ $category->id }}" {{ request('brand_costum_category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>

            <button type="submit" class="bg-[#859873] hover:bg-[#6c7d5c] text-white font-semibold py-2 px-6 rounded-xl transition-colors shadow-sm">
                Filter
            </button>
        </form>
    </div>

    {{-- Kostum Grid --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        @forelse($costums as $costum)
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden relative group flex flex-col">
            <a href="{{ route('member.costums.show', $costum->id) }}" class="absolute inset-0 z-10"></a>

            <div class="absolute top-3 right-3 bg-white/90 backdrop-blur-sm text-[#5c6e46] text-xs font-bold px-3 py-1 rounded-full z-20 shadow-sm">
                Size {{ $costum->size }}
            </div>

            <div class="h-64 w-full bg-gray-100 relative overflow-hidden group">
                @if($costum->photo_url)
                    <img src="{{ Storage::url($costum->photo_url) }}" alt="{{ $costum->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                @else
                    <div class="w-full h-full flex flex-col items-center justify-center text-gray-400 bg-gray-50">
                        <svg class="w-10 h-10 mb-2 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <span class="text-sm">No Image</span>
                    </div>
                @endif
            </div>

            <div class="p-5 flex-grow flex flex-col justify-between">
                <div>
                    <h4 class="font-bold text-gray-800 text-lg truncate" title="{{ $costum->name }}">{{ $costum->name }}</h4>
                    <p class="text-sm text-gray-500 mb-1 truncate" title="{{ $costum->name_anime }}">{{ $costum->name_anime }}</p>
                    <p class="text-xs font-semibold {{ $costum->stock > 0 ? 'text-green-600' : 'text-red-500' }} mb-2">
                        Sisa Stok: {{ $costum->stock }}
                    </p>
                </div>

                <div class="flex items-center justify-between mt-auto pt-4 border-t border-gray-50">
                    <span class="font-bold text-[#859873] text-lg">
                        Rp {{ number_format($costum->priceday, 0, ',', '.') }}
                        <span class="text-xs text-gray-400 font-normal">/ 3 hari</span>
                    </span>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full py-16 bg-white rounded-3xl border border-gray-100 flex flex-col items-center justify-center text-center px-4">
            <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>
            <h3 class="text-lg font-bold text-gray-800 mb-1">Tidak ada kostum ditemukan</h3>
            <p class="text-gray-500">Coba ubah filter pencarian Anda atau kembali lagi nanti.</p>
        </div>
        @endforelse
    </div>
</div>
@endsection
