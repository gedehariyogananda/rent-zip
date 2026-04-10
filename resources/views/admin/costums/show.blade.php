@extends('layouts.admin')

@section('content')
<div class="mb-8">
    <div class="flex items-center gap-2 text-sm text-gray-400 mb-3">
        <a href="{{ route('admin.costums.index') }}" class="hover:text-brand-600 transition-colors">Katalog Kostum</a>
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
        <span class="text-gray-600 font-medium">Detail Kostum</span>
    </div>
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <h1 class="text-3xl font-bold text-brand-800">Detail Kostum</h1>
        <div class="flex gap-2">
            <a href="{{ route('admin.costums.edit', $costum->id) }}" class="px-4 py-2 bg-brand-50 hover:bg-brand-100 text-brand-700 rounded-xl text-sm font-semibold transition-colors flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                Edit Kostum
            </a>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    {{-- Left: Image & Quick Stats --}}
    <div class="lg:col-span-1 space-y-6">
        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6">
            <div class="aspect-square rounded-2xl bg-gray-50 mb-6 overflow-hidden">
                @if($costum->photo_url)
                    <img src="{{ Storage::disk('public')->url($costum->photo_url) }}"
                         alt="{{ $costum->name }}"
                         class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-300" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd" />
                        </svg>
                    </div>
                @endif
            </div>

            <div class="space-y-4">
                <div>
                    <p class="text-sm text-gray-500 font-medium mb-1">Status Ketersediaan</p>
                    <div class="flex items-center gap-2">
                        @if($costum->stock == 0 || $costum->available_stock <= 0)
                            <span class="inline-flex px-3 py-1 rounded-lg text-xs font-bold bg-gray-100 text-gray-600 uppercase tracking-wider">FULL / HABIS</span>
                        @elseif($costum->available_stock <= 2)
                            <span class="inline-flex px-3 py-1 rounded-lg text-xs font-bold bg-orange-100 text-orange-700 uppercase tracking-wider">CLOSING SOON</span>
                        @else
                            <span class="inline-flex px-3 py-1 rounded-lg text-xs font-bold bg-[#d4edda] text-green-800 uppercase tracking-wider">AVAILABLE</span>
                        @endif
                    </div>
                </div>

                <div class="pt-4 border-t border-gray-100">
                    <p class="text-sm text-gray-500 font-medium mb-1">Total Unit Maksimal</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $costum->stock }} <span class="text-base font-medium text-gray-400">Pcs</span></p>
                </div>
                <div>
                    <p class="text-sm text-gray-500 font-medium mb-1">Unit Sedang Tersewa</p>
                    <p class="text-2xl font-bold text-brand-600">{{ $costum->rented_stock }} <span class="text-base font-medium text-brand-400">Pcs</span></p>
                </div>
                <div>
                    <p class="text-sm text-gray-500 font-medium mb-1">Unit Tersedia di Rak</p>
                    <p class="text-2xl font-bold {{ $costum->available_stock > 0 ? 'text-green-600' : 'text-red-500' }}">{{ $costum->available_stock }} <span class="text-base font-medium {{ $costum->available_stock > 0 ? 'text-green-400' : 'text-red-300' }}">Pcs</span></p>
                </div>
            </div>
        </div>
    </div>

    {{-- Right: Details & Maintenance Logs --}}
    <div class="lg:col-span-2 space-y-6">
        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-lg font-bold text-gray-800 mb-6 pb-4 border-b border-gray-50">Informasi Detail</h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Nama Kostum</p>
                    <p class="text-sm font-semibold text-gray-800">{{ $costum->name }}</p>
                </div>
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Nama Anime</p>
                    <p class="text-sm font-semibold text-gray-800">{{ $costum->name_anime ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Source / Brand</p>
                    <div class="flex gap-2">
                        <span class="inline-flex px-2.5 py-1 rounded-lg text-[10px] font-bold bg-brand-50 text-brand-700 uppercase tracking-wider">
                            {{ $costum->sourceAnimeCategory?->name ?? '-' }}
                        </span>
                        <span class="inline-flex px-2.5 py-1 rounded-lg text-[10px] font-bold bg-gray-100 text-gray-600 uppercase tracking-wider">
                            {{ $costum->brandCostumCategory?->name ?? '-' }}
                        </span>
                    </div>
                </div>
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Ukuran / Paxel</p>
                    <div class="flex gap-2">
                        <span class="inline-flex px-2.5 py-1 rounded-lg text-[10px] font-bold bg-gray-100 text-gray-700 uppercase tracking-wider">
                            {{ $costum->size }}
                        </span>
                        <span class="inline-flex px-2.5 py-1 rounded-lg text-[10px] font-bold bg-gray-100 text-gray-700 uppercase tracking-wider">
                            {{ ucfirst($costum->paxel) }}
                        </span>
                    </div>
                </div>
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Berat J&T (Kg)</p>
                    <p class="text-sm font-semibold text-gray-800">{{ $costum->berat_jnt ?? '-' }}</p>
                </div>
                <div class="sm:col-span-2">
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Harga Sewa / 3 Hari</p>
                    <p class="text-lg font-bold text-gray-800">Rp {{ number_format($costum->priceday, 0, ',', '.') }}</p>
                </div>
                <div class="sm:col-span-2">
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Deskripsi Tambahan</p>
                    <div class="text-sm text-gray-600 bg-gray-50 p-4 rounded-xl">
                        {{ $costum->desc ?: 'Tidak ada deskripsi.' }}
                    </div>
                </div>
            </div>
        </div>

        {{-- Mini Log Maintenance --}}
        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center justify-between mb-6 pb-4 border-b border-gray-50">
                <h2 class="text-lg font-bold text-gray-800">Riwayat Penambahan / Pengurangan Stok</h2>
                <a href="{{ route('admin.maintenances.index', ['costum_id' => $costum->id]) }}" class="text-sm font-semibold text-brand-600 hover:text-brand-700">Lihat Semua</a>
            </div>

            <div class="space-y-4">
                @forelse($costum->maintenances()->latest()->take(5)->get() as $log)
                    <div class="flex items-start gap-4 p-4 rounded-xl bg-gray-50 border border-gray-100">
                        <div class="shrink-0 mt-1">
                            @if($log->type === 'penambahan')
                                <div class="w-8 h-8 rounded-full bg-green-100 text-green-600 flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                    </svg>
                                </div>
                            @else
                                <div class="w-8 h-8 rounded-full bg-red-100 text-red-600 flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                                    </svg>
                                </div>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between gap-2 mb-1">
                                <p class="text-sm font-bold text-gray-800">
                                    {{ $log->type === 'penambahan' ? 'Penambahan Stok Baru' : 'Pengurangan Stok' }}
                                    <span class="{{ $log->type === 'penambahan' ? 'text-green-600' : 'text-red-600' }}">({{ $log->type === 'penambahan' ? '+' : '-' }}{{ $log->pcs }})</span>
                                </p>
                                <span class="text-[10px] font-medium text-gray-400 whitespace-nowrap">{{ $log->created_at->diffForHumans() }}</span>
                            </div>
                            @if($log->type === 'pengurangan' && $log->category)
                                <span class="inline-block px-2 py-0.5 bg-gray-200 text-gray-700 text-[10px] font-bold rounded mb-1 uppercase tracking-wider">
                                    {{ $log->category->name }}
                                </span>
                            @endif
                            @if($log->desc)
                                <p class="text-xs text-gray-500 line-clamp-2 mt-1">{{ $log->desc }}</p>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="text-center py-6 text-gray-400 text-sm">
                        Belum ada riwayat perubahan stok pada kostum ini.
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
