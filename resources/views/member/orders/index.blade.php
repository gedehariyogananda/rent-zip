@extends('layouts.member')

@section('title', 'Riwayat Pesanan - ' . config('app.name'))

@section('content')
<div class="space-y-8">

    {{-- Page Header --}}
    <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100">
        <h2 class="text-2xl font-bold text-[#5c6e46] mb-1">Riwayat Pesanan</h2>
        <p class="text-sm text-gray-500">Daftar semua penyewaan kostum kamu</p>
    </div>

    {{-- Orders List --}}
    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
        @if(count($orders) > 0)
            <div class="divide-y divide-gray-100">
                @foreach($orders as $order)
                <div class="p-6 hover:bg-gray-50 transition-colors">
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-4">
                        <div>
                            <div class="flex items-center gap-3 mb-1">
                                <span class="text-sm font-semibold text-gray-500">#{{ $order->code_booking }}</span>
                                <span class="px-3 py-1 text-xs font-bold rounded-full
                                    @if(in_array(strtolower($order->status), ['done', 'completed'])) bg-green-100 text-green-700
                                    @elseif(in_array(strtolower($order->status), ['canceled', 'cancelled', 'batal'])) bg-red-100 text-red-700
                                    @elseif(in_array(strtolower($order->status), ['pending', 'menunggu'])) bg-yellow-100 text-yellow-700
                                    @else bg-blue-100 text-blue-700
                                    @endif">
                                    {{ strtoupper($order->status) }}
                                </span>
                            </div>
                            <p class="text-xs text-gray-500">
                                Disewa: {{ $order->tgl_sewa ? $order->tgl_sewa->format('d M Y') : '-' }} &rarr;
                                Kembali: {{ $order->tgl_pengembalian ? $order->tgl_pengembalian->format('d M Y') : '-' }}
                            </p>
                        </div>

                        <div class="text-left md:text-right">
                            <p class="text-sm text-gray-500 mb-1">Total Belanja</p>
                            <p class="text-lg font-bold text-[#859873]">Rp {{ number_format($order->total, 0, ',', '.') }}</p>
                        </div>
                    </div>

                    {{-- Order Items Preview (Show first item) --}}
                    @php $firstItem = $order->items->first(); @endphp
                    @if($firstItem && $firstItem->costum)
                    <div class="flex items-center gap-4 bg-white border border-gray-100 p-4 rounded-2xl mt-4">
                        <div class="h-16 w-16 bg-gray-100 rounded-xl overflow-hidden flex-shrink-0">
                            @if($firstItem->costum->photo_url)
                                <img src="{{ Storage::url($firstItem->costum->photo_url) }}" alt="{{ $firstItem->costum->name }}" class="w-full h-full object-cover">
                            @endif
                        </div>
                        <div class="flex-grow min-w-0">
                            <h4 class="font-bold text-gray-800 truncate">{{ $firstItem->costum->name }}</h4>
                            <p class="text-sm text-gray-500">{{ $firstItem->pcs }} Barang</p>
                        </div>
                        @if($order->items->count() > 1)
                        <div class="flex-shrink-0 text-sm font-medium text-gray-400">
                            +{{ $order->items->count() - 1 }} kostum lainnya
                        </div>
                        @endif
                        <div class="flex-shrink-0 ml-4">
                            <a href="{{ route('member.orders.show', $order->id) }}" class="inline-block bg-white text-[#859873] border border-[#859873] hover:bg-[#859873] hover:text-white font-semibold text-sm py-2 px-4 rounded-xl transition-colors">
                                Lihat Detail
                            </a>
                        </div>
                    </div>
                    @else
                    <div class="mt-4 text-right">
                        <a href="{{ route('member.orders.show', $order->id) }}" class="inline-block bg-[#859873] text-white hover:bg-[#6c7d5c] font-semibold text-sm py-2 px-4 rounded-xl transition-colors">
                            Lihat Detail
                        </a>
                    </div>
                    @endif
                </div>
                @endforeach
            </div>
        @else
            <div class="py-16 flex flex-col items-center justify-center text-center px-4">
                <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                    <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-800 mb-1">Belum ada pesanan</h3>
                <p class="text-gray-500 mb-6">Kamu belum pernah menyewa kostum. Yuk lihat katalog kami!</p>
                <a href="{{ route('member.costums.index') }}" class="bg-[#859873] hover:bg-[#6c7d5c] text-white font-semibold py-3 px-6 rounded-xl transition-colors">
                    Mulai Cari Kostum
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
