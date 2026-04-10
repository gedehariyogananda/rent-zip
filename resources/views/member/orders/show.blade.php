@extends('layouts.member')

@section('title', 'Detail Pesanan #' . $order->code_booking . ' - ' . config('app.name'))

@section('content')
<div class="space-y-6">

    {{-- Breadcrumb & Back Button --}}
    <div class="flex items-center gap-4">
        <a href="{{ route('member.orders.index') }}" class="text-gray-500 hover:text-[#859873] transition-colors flex items-center gap-2 font-medium">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali ke Riwayat Pesanan
        </a>
    </div>

    {{-- Order Header --}}
    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 mb-1">Pesanan #{{ $order->code_booking }}</h2>
            <p class="text-sm text-gray-500">Dibuat pada {{ $order->created_at ? $order->created_at->format('d M Y, H:i') : '-' }}</p>
        </div>
        <div>
            <span class="px-4 py-2 text-sm font-bold rounded-full inline-block text-center w-full md:w-auto
                @if(in_array(strtolower($order->status), ['done', 'completed'])) bg-green-100 text-green-700
                @elseif(in_array(strtolower($order->status), ['canceled', 'cancelled', 'batal'])) bg-red-100 text-red-700
                @elseif(in_array(strtolower($order->status), ['pending', 'menunggu'])) bg-yellow-100 text-yellow-700
                @else bg-blue-100 text-blue-700
                @endif">
                {{ strtoupper($order->status) }}
            </span>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Left Content: Order Items --}}
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-100">
                    <h3 class="text-lg font-bold text-gray-800">Daftar Kostum Disewa</h3>
                </div>

                <div class="divide-y divide-gray-100 p-6">
                    @forelse($order->items as $item)
                    <div class="py-4 first:pt-0 last:pb-0 flex flex-col sm:flex-row items-center gap-4">
                        <div class="h-24 w-24 bg-gray-100 rounded-xl overflow-hidden flex-shrink-0">
                            @if($item->costum && $item->costum->photo_url)
                                <img src="{{ Storage::url($item->costum->photo_url) }}" alt="{{ $item->costum->name }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-400 bg-gray-50">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                            @endif
                        </div>

                        <div class="flex-grow min-w-0 text-center sm:text-left">
                            @if($item->costum)
                                <a href="{{ route('member.costums.show', $item->costum->id) }}" class="font-bold text-gray-800 text-lg hover:text-[#859873] transition-colors inline-block">{{ $item->costum->name }}</a>
                                <p class="text-xs font-semibold text-[#859873] mb-2 uppercase tracking-wider">{{ $item->costum->name_anime }}</p>
                                <div class="flex flex-wrap items-center justify-center sm:justify-start gap-2 text-sm text-gray-600">
                                    <span class="bg-gray-100 px-2 py-1 rounded-md font-medium">Size: {{ $item->costum->size }}</span>
                                    <span>{{ $item->pcs }} pcs x Rp {{ number_format($item->costum->priceday, 0, ',', '.') }}</span>
                                </div>
                                @if($item->costum->lokasi)
                                    <p class="text-sm text-gray-500 mt-2 bg-gray-50 p-2 rounded-lg inline-block border border-gray-100"><span class="font-semibold text-gray-700">Lokasi:</span> {{ $item->costum->lokasi }}</p>
                                @endif
                            @else
                                <h4 class="font-bold text-gray-800 text-lg mb-1">Kostum tidak ditemukan</h4>
                            @endif
                        </div>

                        @if($item->costum)
                        <div class="flex-shrink-0 text-right font-bold text-[#859873] text-lg">
                            Rp {{ number_format($item->costum->priceday * $item->pcs, 0, ',', '.') }}
                        </div>
                        @endif
                    </div>
                    @empty
                    <div class="text-center py-8 text-gray-500">
                        Tidak ada item dalam pesanan ini.
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Right Content: Order Summary & Info --}}
        <div class="space-y-6">
            {{-- Rent Duration --}}
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Informasi Sewa</h3>

                <div class="space-y-4">
                    <div class="flex items-start gap-3">
                        <div class="p-2 bg-[#f2f4ec] rounded-lg text-[#5c6e46]">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 uppercase font-semibold">Tanggal Sewa</p>
                            <p class="font-bold text-gray-800">{{ $order->tgl_sewa ? $order->tgl_sewa->format('d F Y') : '-' }}</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-3">
                        <div class="p-2 bg-[#f2f4ec] rounded-lg text-[#5c6e46]">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 uppercase font-semibold">Tanggal Kembali</p>
                            <p class="font-bold text-gray-800">{{ $order->tgl_pengembalian ? $order->tgl_pengembalian->format('d F Y') : '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Summary --}}
            <div class="bg-[#e2e8d3] rounded-3xl shadow-sm p-6">
                <h3 class="text-lg font-bold text-[#5c6e46] mb-4">Ringkasan Pembayaran</h3>

                <div class="space-y-2 mb-4 text-[#72855a]">
                    <div class="flex justify-between items-center text-sm">
                        <span>Total Harga Sewa</span>
                        <span class="font-semibold">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between items-center text-sm">
                        <span>Biaya Layanan</span>
                        <span class="font-semibold">Rp 0</span>
                    </div>
                </div>

                <div class="border-t border-[#c6d0b6] pt-4 mt-4">
                    <div class="flex justify-between items-center">
                        <span class="font-bold text-[#5c6e46]">Total Keseluruhan</span>
                        <span class="text-xl font-extrabold text-[#5c6e46]">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>
@endsection
