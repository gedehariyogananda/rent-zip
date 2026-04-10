@extends('layouts.admin')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-brand-800 mb-2">Kategori</h1>
    <p class="text-gray-500">Kelola kategori source anime, brand kostum, pengeluaran, dan maintenance.</p>
</div>

{{-- Tab + Tambah --}}
<div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-6 gap-4">
    <div class="flex flex-wrap gap-2">
        <a href="{{ route('admin.master.categories.index', ['type' => 'source_anime']) }}"
           class="px-5 py-2 rounded-xl text-sm font-semibold transition-colors
                  {{ $type === 'source_anime' ? 'bg-brand-700 text-white shadow-sm' : 'bg-white text-gray-600 border border-gray-200 hover:bg-gray-50' }}">
            Source Anime
        </a>
        <a href="{{ route('admin.master.categories.index', ['type' => 'brand']) }}"
           class="px-5 py-2 rounded-xl text-sm font-semibold transition-colors
                  {{ $type === 'brand' ? 'bg-brand-700 text-white shadow-sm' : 'bg-white text-gray-600 border border-gray-200 hover:bg-gray-50' }}">
            Brand Costum
        </a>
        <a href="{{ route('admin.master.categories.index', ['type' => 'pengeluaran']) }}"
           class="px-5 py-2 rounded-xl text-sm font-semibold transition-colors
                  {{ $type === 'pengeluaran' ? 'bg-orange-600 text-white shadow-sm' : 'bg-white text-gray-600 border border-gray-200 hover:bg-gray-50' }}">
            Pengeluaran
        </a>
        <a href="{{ route('admin.master.categories.index', ['type' => 'maintenance']) }}"
           class="px-5 py-2 rounded-xl text-sm font-semibold transition-colors
                  {{ $type === 'maintenance' ? 'bg-red-600 text-white shadow-sm' : 'bg-white text-gray-600 border border-gray-200 hover:bg-gray-50' }}">
            Maintenance Log
        </a>
    </div>
    <a href="{{ route('admin.master.categories.create', ['type' => $type]) }}"
       class="flex items-center gap-2 px-5 py-2.5 bg-brand-700 hover:bg-brand-800 text-white rounded-xl text-sm font-bold transition-colors shadow-sm whitespace-nowrap">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
        </svg>
        Tambah Kategori
    </a>
</div>

<div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="p-6 border-b border-gray-50 flex items-center justify-between">
        <h2 class="text-xl font-bold text-gray-800">
            Daftar Kategori
            @if($type === 'source_anime') Source Anime
            @elseif($type === 'brand') Brand Costum
            @elseif($type === 'pengeluaran') Pengeluaran
            @else Maintenance Log @endif
        </h2>
        <span class="text-xs font-bold tracking-wider uppercase px-3 py-1 rounded-full bg-gray-100 text-gray-700">
            {{ $categories->total() }} total
        </span>
    </div>

    <div class="p-6">
        {{-- Table Header --}}
        <div class="grid grid-cols-12 gap-4 pb-4 border-b border-gray-50 text-xs font-bold text-gray-400 uppercase tracking-wider px-4">
            <div class="col-span-1">#</div>
            <div class="{{ in_array($type, ['source_anime', 'brand']) ? 'col-span-4' : 'col-span-9' }}">NAMA KATEGORI</div>
            @if(in_array($type, ['source_anime', 'brand']))
                <div class="col-span-5">DESKRIPSI</div>
            @endif
            <div class="col-span-2 text-right">AKSI</div>
        </div>

        {{-- Table Body --}}
        <div class="space-y-3 mt-4">
            @forelse($categories as $category)
            @php $no = ($categories->currentPage() - 1) * $categories->perPage() + $loop->iteration; @endphp
            <div class="grid grid-cols-12 gap-4 items-center p-4 bg-gray-50/50 rounded-xl hover:bg-gray-50 transition-colors">
                <div class="col-span-1 text-sm font-bold text-gray-400">{{ $no }}</div>

                <div class="{{ in_array($type, ['source_anime', 'brand']) ? 'col-span-4' : 'col-span-9' }} flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center flex-shrink-0 bg-brand-100 text-brand-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 2a4 4 0 00-4 4v1H5a1 1 0 00-.994.89l-1 9A1 1 0 004 18h12a1 1 0 00.994-1.11l-1-9A1 1 0 0015 7h-1V6a4 4 0 00-4-4zm2 5V6a2 2 0 10-4 0v1h4zm-6 3a1 1 0 112 0 1 1 0 01-2 0zm7-1a1 1 0 100 2 1 1 0 000-2z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <span class="text-sm font-semibold text-gray-800">{{ $category->name }}</span>
                </div>

                @if(in_array($type, ['source_anime', 'brand']))
                    <div class="col-span-5 text-sm text-gray-500 truncate">
                        {{ $category->desc ?? '-' }}
                    </div>
                @endif

                <div class="col-span-2 flex justify-end relative group">
                    <button class="text-gray-400 hover:text-gray-600 p-1 focus:outline-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z" />
                        </svg>
                    </button>
                    <div class="absolute right-0 top-8 w-32 bg-white rounded-lg shadow-lg border border-gray-100 py-1 z-10 hidden group-hover:block group-focus-within:block">
                        <a href="{{ route('admin.master.categories.edit', [$category->id, 'type' => $type]) }}"
                           class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Edit</a>
                        <form action="{{ route('admin.master.categories.destroy', [$category->id, 'type' => $type]) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    onclick="return confirm('Hapus kategori \'{{ $category->name }}\'?')"
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
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                </div>
                <p class="text-gray-500 text-sm font-medium">Belum ada data kategori.</p>
                <a href="{{ route('admin.master.categories.create', ['type' => $type]) }}"
                   class="mt-3 inline-flex items-center text-sm font-semibold text-brand-600 hover:text-brand-800">
                    + Tambah sekarang
                </a>
            </div>
            @endforelse
        </div>

        <x-pagination :paginator="$categories" label="kategori" />
    </div>
</div>
@endsection
