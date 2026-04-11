@extends('layouts.member')

@section('title', $costum->name . ' - Detail Kostum')

@section('content')
<div class="space-y-6">

    {{-- Breadcrumb & Back Button --}}
    <div class="flex items-center gap-4">
        <a href="{{ route('member.costums.index') }}" class="text-gray-500 hover:text-[#859873] transition-colors flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali ke Katalog
        </a>
    </div>

    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 p-8">

            {{-- Image Gallery --}}
            <div class="space-y-4">
                <div class="aspect-w-3 aspect-h-4 md:aspect-w-1 md:aspect-h-1 rounded-2xl overflow-hidden bg-gray-100 border border-gray-100 relative">
                    @if($costum->photo_url)
                        <img src="{{ Storage::url($costum->photo_url) }}" alt="{{ $costum->name }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex flex-col items-center justify-center text-gray-400">
                            <svg class="w-16 h-16 mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <span>No Image Available</span>
                        </div>
                    @endif

                    <div class="absolute top-4 right-4 bg-white/90 backdrop-blur-sm text-[#5c6e46] font-bold px-4 py-2 rounded-full shadow-sm">
                        Size {{ $costum->size }}
                    </div>
                </div>
            </div>

            {{-- Details --}}
            <div class="flex flex-col">
                <div class="mb-6">
                    <p class="text-sm font-semibold text-[#859873] mb-1 uppercase tracking-wider">{{ $costum->name_anime }}</p>
                    @if($costum->nama_cosplayer)
                        <p class="text-xs font-bold text-gray-500 mb-2 uppercase tracking-wider">Cosplayer: {{ $costum->nama_cosplayer }}</p>
                    @endif
                    <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-4">{{ $costum->name }}</h1>

                    <div class="flex items-center gap-4 mb-6">
                        <div class="bg-[#f2f4ec] text-[#5c6e46] px-4 py-2 rounded-xl">
                            <span class="text-sm text-gray-500 block">Harga Sewa (3 Hari)</span>
                            <span class="text-2xl font-bold">Rp {{ number_format($costum->priceday, 0, ',', '.') }}</span>
                        </div>
                        <div class="bg-gray-50 px-4 py-2 rounded-xl border border-gray-100">
                            <span class="text-sm text-gray-500 block">Status Stok</span>
                            <span class="text-lg font-bold {{ $costum->stock > 0 ? 'text-green-600' : 'text-red-600' }}">
                                {{ $costum->stock > 0 ? 'Tersedia (' . $costum->stock . ' pcs)' : 'Habis' }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="space-y-6 flex-grow border-t border-gray-100 pt-6">
                    <div>
                        <h3 class="text-lg font-bold text-gray-800 mb-2">Deskripsi Kostum</h3>
                        <p class="text-gray-600 leading-relaxed whitespace-pre-line">{{ $costum->desc ?: 'Tidak ada deskripsi untuk kostum ini.' }}</p>
                    </div>

                    <div>
                        <h3 class="text-lg font-bold text-gray-800 mb-2">Lokasi</h3>
                        <p class="text-gray-600 leading-relaxed whitespace-pre-line">{{ $costum->lokasi ?: 'Belum ada informasi lokasi.' }}</p>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-gray-50 p-4 rounded-xl border border-gray-100">
                            <span class="text-xs text-gray-500 uppercase font-semibold">Ukuran Paket (Paxel)</span>
                            <p class="font-bold text-gray-800 capitalize">{{ $costum->paxel }}</p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-xl border border-gray-100">
                            <span class="text-xs text-gray-500 uppercase font-semibold">Berat J&T</span>
                            <p class="font-bold text-gray-800">{{ $costum->berat_jnt }} Kg</p>
                        </div>
                    </div>
                </div>

                <div class="mt-8 pt-6 border-t border-gray-100">
                    <button type="button" onclick="showOrderPopup()" class="w-full bg-[#859873] hover:bg-[#6c7d5c] text-white font-bold text-lg py-4 px-8 rounded-2xl transition-colors shadow-md flex items-center justify-center gap-2 {{ $costum->stock < 1 ? 'opacity-50 cursor-not-allowed' : '' }}" {{ $costum->stock < 1 ? 'disabled' : '' }}>
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        Pesan Sekarang
                    </button>
                    @if($costum->stock < 1)
                        <p class="text-center text-red-500 text-sm mt-2 font-medium">Maaf, kostum ini sedang tidak tersedia.</p>
                    @endif
                </div>

            </div>
        </div>
    </div>
</div>

{{-- Popup Modal --}}
<div id="orderModal" class="fixed inset-0 z-50 hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    {{-- Background Overlay --}}
    <div class="fixed inset-0 bg-gray-900 bg-opacity-50 transition-opacity backdrop-blur-sm" aria-hidden="true" onclick="hideOrderPopup()"></div>

    <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
            <div class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-md border border-gray-100">
                <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-[#e2e8d3] sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-[#5c6e46]" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 1.5H8.25A2.25 2.25 0 006 3.75v16.5a2.25 2.25 0 002.25 2.25h7.5A2.25 2.25 0 0018 20.25V3.75a2.25 2.25 0 00-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 18.75h3" />
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                            <h3 class="text-lg font-bold leading-6 text-gray-900" id="modal-title">Pemberitahuan Pemesanan</h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">
                                    Silahkan melakukan pemesanan pada <b>Aplikasi Mobile</b> kami ya. Untuk saat ini website hanya berfungsi sebagai katalog kostum.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                    <button type="button" onclick="hideOrderPopup()" class="inline-flex w-full justify-center rounded-xl bg-[#859873] px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-[#6c7d5c] sm:ml-3 sm:w-auto transition-colors">
                        Mengerti
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function showOrderPopup() {
        document.getElementById('orderModal').classList.remove('hidden');
    }

    function hideOrderPopup() {
        document.getElementById('orderModal').classList.add('hidden');
    }
</script>
@endsection
