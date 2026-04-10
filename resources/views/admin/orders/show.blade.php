@extends('layouts.admin')

@section('content')
<div class="mb-4 flex gap-2 justify-end">
    @if(strtolower($order->status) === 'pending')
        <a href="{{ route('admin.orders.edit', $order->id) }}" class="px-4 py-2 bg-brand-600 text-white rounded-xl hover:bg-brand-700 font-semibold text-sm">Edit Pesanan</a>
        <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST">
            @csrf
            @method('PATCH')
            <input type="hidden" name="status" value="canceled">
            <button type="submit" onclick="return confirm('Cancel pesanan ini?')" class="px-4 py-2 bg-orange-600 text-white rounded-xl hover:bg-orange-700 font-semibold text-sm">Cancel Payment</button>
        </form>
    @endif
    @if(strtolower($order->status) === 'paid')
        <form action="{{ route('admin.orders.confirmReturn', $order->id) }}" method="POST">
            @csrf
            @method('PATCH')
            <button type="submit" onclick="return confirm('Konfirmasi pengembalian? Stok akan bertambah kembali.')" class="px-4 py-2 bg-blue-600 text-white rounded-xl hover:bg-blue-700 font-semibold text-sm">Konfirmasi Pengembalian Kostum</button>
        </form>
    @endif
</div>
<div class="mb-8 flex items-center justify-between">
    <div class="flex items-center gap-4">
        <a href="{{ route('admin.orders.index') }}" class="w-10 h-10 bg-white rounded-xl flex items-center justify-center text-gray-500 hover:text-brand-700 hover:bg-brand-50 transition-colors shadow-sm border border-gray-100">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
            </svg>
        </a>
        <div>
            <h1 class="text-3xl font-bold text-gray-800 mb-1">Detail Pesanan</h1>
            <p class="text-sm text-gray-500">Nomor Transaksi: <span class="font-bold text-brand-700">{{ $order->code_booking ?? 'TRX-'.$order->id }}</span></p>
        </div>
    </div>
</div>

@if(session('success'))
<div class="mb-6 p-4 rounded-xl bg-green-50 text-green-600 text-sm font-semibold flex items-center gap-2">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
    </svg>
    {{ session('success') }}
</div>
@endif

@if(session('error'))
<div class="mb-6 p-4 rounded-xl bg-red-50 text-red-600 text-sm font-semibold flex items-center gap-2">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
    </svg>
    {{ session('error') }}
</div>
@endif

@php
    $status = strtolower($order->status);
    $bgStatus = 'bg-gray-100';
    $textStatus = 'text-gray-700';

    if ($status === 'pending') {
        $bgStatus = 'bg-orange-100';
        $textStatus = 'text-orange-700';
    } elseif ($status === 'paid') {
        $bgStatus = 'bg-green-100';
        $textStatus = 'text-green-700';
    } elseif ($status === 'canceled') {
        $bgStatus = 'bg-red-100';
        $textStatus = 'text-red-700';
    } elseif ($status === 'done') {
        $bgStatus = 'bg-blue-100';
        $textStatus = 'text-blue-700';
    }

    $hasOutOfStock = false;
    if ($status === 'pending') {
        foreach($order->items as $item) {
            if ($item->costum && $item->pcs > $item->costum->available_stock) {
                $hasOutOfStock = true;
                break;
            }
        }
    }

    $tglSewa = \Carbon\Carbon::parse($order->tgl_sewa);
    $tglKembali = \Carbon\Carbon::parse($order->tgl_pengembalian);
    $days = $tglSewa->diffInDays($tglKembali);
    if($days == 0) $days = 1;
@endphp

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    {{-- Left Column: Costumes & Dates --}}
    <div class="lg:col-span-2 space-y-8">
        {{-- Dates Info --}}
        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 flex flex-wrap gap-8 items-center">
            <div>
                <span class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Tanggal Sewa</span>
                <p class="text-lg font-semibold text-gray-800">{{ $tglSewa->format('d M Y') }}</p>
            </div>
            <div class="hidden md:block text-gray-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
            </div>
            <div>
                <span class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Tanggal Kembali</span>
                <p class="text-lg font-semibold text-gray-800">{{ $tglKembali->format('d M Y') }}</p>
            </div>
            <div class="ml-auto pl-8 border-l border-gray-100">
                <span class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Durasi</span>
                <p class="text-xl font-bold text-brand-700">{{ $days }} Hari</p>
            </div>
        </div>

        {{-- Costumes List --}}
        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-6 border-b border-gray-50">
                <h3 class="text-lg font-bold text-gray-800">Daftar Kostum Sewa</h3>
            </div>
            <div class="p-6">
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="border-b border-gray-100">
                                <th class="pb-3 text-xs font-bold text-gray-400 uppercase tracking-wider">Kostum</th>
                                <th class="pb-3 text-xs font-bold text-gray-400 uppercase tracking-wider text-center">Harga/3 Hari</th>
                                <th class="pb-3 text-xs font-bold text-gray-400 uppercase tracking-wider text-center">Jumlah</th>
                                <th class="pb-3 text-xs font-bold text-gray-400 uppercase tracking-wider text-right">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @foreach($order->items as $item)
                            <tr>
                                <td class="py-4">
                                    <p class="text-sm font-bold text-gray-800">{{ $item->costum->name ?? 'Kostum Dihapus' }}</p>
                                    @if($status === 'pending' && $item->costum && $item->pcs > $item->costum->available_stock)
                                        <p class="text-xs text-red-600 font-semibold mt-1">Stok tidak mencukupi (Tersedia: {{ $item->costum->available_stock }})</p>
                                    @endif
                                </td>
                                <td class="py-4 text-center">
                                    <p class="text-sm text-gray-600">Rp {{ number_format($item->costum->priceday ?? 0, 0, ',', '.') }}</p>
                                </td>
                                <td class="py-4 text-center">
                                    <p class="text-sm font-bold text-gray-800">{{ $item->pcs }} pcs</p>
                                </td>
                                <td class="py-4 text-right">
                                    @php
                                        $subtotal = ($item->costum ? $item->costum->calculatePrice($days) : 0) * $item->pcs;
                                    @endphp
                                    <p class="text-sm font-bold text-brand-700">Rp {{ number_format($subtotal, 0, ',', '.') }}</p>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="border-t-2 border-gray-100">
                                <td colspan="3" class="pt-4 text-right text-sm font-bold text-gray-600">Grand Total:</td>
                                <td class="pt-4 text-right">
                                    <p class="text-xl font-black text-brand-800">Rp {{ number_format($order->total, 0, ',', '.') }}</p>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Right Column: Customer & Payment --}}
    <div class="space-y-8">
        {{-- Status & Payment Actions --}}
        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-6 border-b border-gray-50 flex items-center justify-between">
                <h3 class="text-lg font-bold text-gray-800">Status & Pembayaran</h3>
                <span class="px-3 py-1 text-xs font-bold rounded-full {{ $bgStatus }} {{ $textStatus }} uppercase tracking-wider">
                    {{ $status }}
                </span>
            </div>

            <div class="p-6">
                @if($status === 'pending')
                    @if($hasOutOfStock)
                        <div class="mb-4 p-3 rounded-xl bg-red-50 border border-red-100 flex gap-2 items-start text-red-600 text-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                            <p><strong>Tidak dapat memproses pembayaran.</strong> Stok beberapa kostum tidak mencukupi untuk saat ini. Silakan cancel atau tunggu hingga stok kembali.</p>
                        </div>
                    @endif
                    <div class="space-y-4">
                        {{-- Direct Verification --}}
                        <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="paid">
                            <button type="submit" onclick="return confirm('Konfirmasi bahwa pembayaran telah diterima secara langsung (Cash/Transfer Manual)?')" class="w-full flex items-center justify-center gap-2 px-5 py-3 bg-green-500 hover:bg-green-600 text-white rounded-xl text-sm font-bold transition-colors shadow-sm disabled:opacity-50 disabled:cursor-not-allowed" {{ $hasOutOfStock ? 'disabled' : '' }}>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                                Bayar Disetujui (Langsung)
                            </button>
                        </form>

                        {{-- Generate QRIS if not exists --}}
                        @if(!$order->qris && $status === 'pending')
                            <div class="relative py-4 flex items-center">
                                <div class="flex-grow border-t border-gray-200"></div>
                                <span class="flex-shrink-0 mx-4 text-xs font-semibold text-gray-400 uppercase">ATAU</span>
                                <div class="flex-grow border-t border-gray-200"></div>
                            </div>

                            <form action="{{ route('admin.orders.qris', $order->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full flex items-center justify-center gap-2 px-5 py-3 bg-brand-100 hover:bg-brand-200 text-brand-700 rounded-xl text-sm font-bold transition-colors shadow-sm disabled:opacity-50 disabled:cursor-not-allowed" {{ $hasOutOfStock ? 'disabled' : '' }}>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h3a1 1 0 011 1v3a1 1 0 01-1 1H4a1 1 0 01-1-1V4zm2 2V5h1v1H5zM3 13a1 1 0 011-1h3a1 1 0 011 1v3a1 1 0 01-1 1H4a1 1 0 01-1-1v-3zm2 2v-1h1v1H5zM13 3a1 1 0 00-1 1v3a1 1 0 001 1h3a1 1 0 001-1V4a1 1 0 00-1-1h-3zm1 2v1h1V5h-1z" clip-rule="evenodd" />
                                        <path d="M11 4a1 1 0 10-2 0v1a1 1 0 002 0V4zM10 7a1 1 0 011 1v1h2a1 1 0 110 2h-3a1 1 0 01-1-1V8a1 1 0 011-1zM16 9a1 1 0 100 2 1 1 0 000-2zM9 13a1 1 0 011-1h1a1 1 0 110 2v2a1 1 0 11-2 0v-3zM7 11a1 1 0 100-2H4a1 1 0 100 2h3zM17 13a1 1 0 01-1 1h-2a1 1 0 110-2h2a1 1 0 011 1zM16 17a1 1 0 100-2h-3a1 1 0 100 2h3z" />
                                    </svg>
                                    Buat QRIS Pembayaran
                                </button>
                            </form>
                        @endif
                    </div>
                @endif

                {{-- Display QRIS --}}
                @if($order->qris && $status === 'pending')
                    <div class="mt-6 pt-6 border-t border-gray-100 text-center">
                        <p class="text-sm font-bold text-gray-800 mb-4">Minta Pelanggan Scan QRIS Ini</p>
                        <div class="bg-white p-3 inline-block rounded-2xl shadow-sm border border-gray-100 mb-6">
                            <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data={{ $order->qris }}" alt="QRIS" class="w-48 h-48 rounded-xl">
                        </div>

                        <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="paid">
                            <button type="submit" onclick="return confirm('Konfirmasi pembayaran telah masuk melalui QRIS?')" class="w-full flex items-center justify-center gap-2 px-5 py-3 bg-brand-700 hover:bg-brand-800 text-white rounded-xl text-sm font-bold transition-colors shadow-sm disabled:opacity-50 disabled:cursor-not-allowed" {{ $hasOutOfStock ? 'disabled' : '' }}>
                                Verifikasi Pembayaran Masuk
                            </button>
                        </form>
                    </div>
                @endif

                @if($status !== 'pending')
                    <div class="text-center py-4">
                        <div class="w-16 h-16 mx-auto mb-3 rounded-full {{ $bgStatus }} flex items-center justify-center {{ $textStatus }}">
                            @if(in_array($status, ['paid', 'done']))
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            @endif
                        </div>
                        <p class="text-sm font-bold text-gray-800">Pesanan Telah {{ $status === 'canceled' ? 'Dibatalkan' : 'Selesai / Dibayar' }}</p>
                    </div>
                @endif
            </div>
        </div>

        {{-- Customer Details Card --}}
        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-6 border-b border-gray-50 flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-brand-100 text-brand-700 flex items-center justify-center flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-sm font-bold text-gray-800">{{ $order->user->username ?? 'Pelanggan Dihapus' }}</h3>
                    <p class="text-xs font-semibold text-brand-600">{{ $order->user->email ?? 'Tidak ada email' }}</p>
                </div>
            </div>
            <div class="p-6 space-y-4">
                <div>
                    <span class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Nomor Telepon</span>
                    <p class="text-sm font-semibold text-gray-800">{{ $order->user->phone ?? '-' }}</p>
                </div>
                <div>
                    <span class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Nomor Darurat</span>
                    <p class="text-sm font-semibold text-gray-800">{{ $order->user->profile->no_darurat ?? '-' }}</p>
                </div>
                <div>
                    <span class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Alamat</span>
                    <p class="text-sm font-semibold text-gray-800 leading-relaxed">{{ $order->user->address ?? '-' }}</p>
                </div>

                @if($order->user_id)
                <div class="pt-4 border-t border-gray-50">
                    <a href="{{ route('admin.users.show', $order->user_id) }}" class="text-sm font-bold text-brand-600 hover:text-brand-800 flex items-center gap-1 transition-colors">
                        Lihat Profil Lengkap
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                        </svg>
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
