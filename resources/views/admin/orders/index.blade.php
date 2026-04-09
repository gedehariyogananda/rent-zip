@extends('layouts.admin')

@section('content')
<div class="mb-8 flex items-center justify-between">
    <div>
        <h1 class="text-3xl font-bold text-brand-800 mb-2">Transaksi Sewa</h1>
        <p class="text-gray-500">Kelola semua pesanan dan transaksi penyewaan kostum.</p>
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

<form action="{{ route('admin.orders.index') }}" method="GET" class="mb-6 bg-white p-4 rounded-3xl shadow-sm border border-gray-100 flex flex-wrap gap-4 items-end">
    <div class="flex-1 min-w-[200px]">
        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Pencarian</label>
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari kode atau nama..." class="w-full rounded-xl border-gray-200 focus:border-brand-500 focus:ring-brand-500">
    </div>

    <div class="w-48">
        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Filter Transaksi</label>
        <select name="filter_transaction" class="w-full rounded-xl border-gray-200 focus:border-brand-500 focus:ring-brand-500" onchange="toggleTransDateRange(this.value)">
            <option value="">Semua</option>
            <option value="range" {{ request('filter_transaction') == 'range' ? 'selected' : '' }}>Range Tanggal</option>
        </select>
    </div>

    <div id="trans-date-range-inputs" class="flex gap-4 {{ request('filter_transaction') == 'range' ? '' : 'hidden' }}">
        <div>
            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Dari</label>
            <input type="date" name="trans_start_date" value="{{ request('trans_start_date') }}" class="w-full rounded-xl border-gray-200 focus:border-brand-500 focus:ring-brand-500">
        </div>
        <div>
            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Sampai</label>
            <input type="date" name="trans_end_date" value="{{ request('trans_end_date') }}" class="w-full rounded-xl border-gray-200 focus:border-brand-500 focus:ring-brand-500">
        </div>
    </div>

    <div class="w-48">
        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Filter Pengembalian</label>
        <select name="filter_return" class="w-full rounded-xl border-gray-200 focus:border-brand-500 focus:ring-brand-500" onchange="toggleDateRange(this.value)">
            <option value="">Semua</option>
            <option value="today" {{ request('filter_return') == 'today' ? 'selected' : '' }}>Hari Ini</option>
            <option value="range" {{ request('filter_return') == 'range' ? 'selected' : '' }}>Range Tanggal</option>
        </select>
    </div>

    <div id="date-range-inputs" class="flex gap-4 {{ request('filter_return') == 'range' ? '' : 'hidden' }}">
        <div>
            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Dari</label>
            <input type="date" name="start_date" value="{{ request('start_date') }}" class="w-full rounded-xl border-gray-200 focus:border-brand-500 focus:ring-brand-500">
        </div>
        <div>
            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Sampai</label>
            <input type="date" name="end_date" value="{{ request('end_date') }}" class="w-full rounded-xl border-gray-200 focus:border-brand-500 focus:ring-brand-500">
        </div>
    </div>

    <div class="flex gap-2">
        <button type="submit" class="px-6 py-2.5 bg-brand-600 text-white rounded-xl hover:bg-brand-700 font-semibold shadow-sm shadow-brand-200 transition-all">
            Filter
        </button>
        <a href="{{ route('admin.orders.index') }}" class="px-4 py-2.5 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 font-semibold transition-all">
            Reset
        </a>
        <button type="submit" name="export" value="excel" class="px-4 py-2.5 bg-green-600 text-white rounded-xl hover:bg-green-700 font-semibold shadow-sm shadow-green-200 transition-all flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3M3 17V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
            </svg>
            Excel
        </button>
    </div>
</form>

<script>
function toggleTransDateRange(val) {
    const el = document.getElementById('trans-date-range-inputs');
    if (val === 'range') {
        el.classList.remove('hidden');
    } else {
        el.classList.add('hidden');
    }
}
function toggleDateRange(val) {
    const el = document.getElementById('date-range-inputs');
    if (val === 'range') {
        el.classList.remove('hidden');
    } else {
        el.classList.add('hidden');
    }
}
</script>

<div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-visible">
    <div class="p-6 border-b border-gray-50 flex items-center justify-between">
        <h2 class="text-xl font-bold text-gray-800">Daftar Transaksi</h2>
        <span class="text-xs font-bold tracking-wider uppercase px-3 py-1 rounded-full bg-brand-50 text-brand-700">
            {{ $orders->count() }} total
        </span>
    </div>

    <div class="p-6">
        <div class="overflow-x-auto overflow-y-visible pb-32">
            <div class="min-w-[900px] grid grid-cols-12 gap-4 pb-4 border-b border-gray-50 text-xs font-bold text-gray-400 uppercase tracking-wider px-4">
                <div class="col-span-1">#</div>
                <div class="col-span-3">KODE & TANGGAL TRANSAKSI</div>
                <div class="col-span-3">PELANGGAN & TANGGAL SEWA</div>
                <div class="col-span-2">TOTAL</div>
                <div class="col-span-2 text-center">STATUS</div>
                <div class="col-span-1 text-right">AKSI</div>
            </div>

            <div class="min-w-[900px] space-y-3 mt-4 min-h-[250px]">
                @forelse($orders as $order)
                <div class="grid grid-cols-12 gap-4 items-center p-4 bg-gray-50/50 rounded-xl hover:bg-gray-50 transition-colors">
                    <div class="col-span-1 text-sm font-bold text-gray-400">{{ $loop->iteration }}</div>

                    <div class="col-span-3">
                        <p class="text-sm font-bold text-gray-800">{{ $order->code_booking ?? 'TRX-'.$order->id }}</p>
                        <p class="text-xs text-gray-500 mt-0.5">Dibuat: {{ $order->created_at->format('d M Y H:i') }}</p>
                    </div>

                    <div class="col-span-3 flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg flex items-center justify-center flex-shrink-0 bg-brand-100 text-brand-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-800">{{ $order->user->username ?? 'Pelanggan Dihapus' }}</p>
                            <p class="text-xs text-gray-500 mt-0.5">Sewa: {{ \Carbon\Carbon::parse($order->tgl_sewa)->format('d M Y') }} s/d {{ \Carbon\Carbon::parse($order->tgl_pengembalian)->format('d M Y') }}</p>
                        </div>
                    </div>

                    <div class="col-span-2">
                        <p class="text-sm font-bold text-brand-700">Rp {{ number_format($order->total, 0, ',', '.') }}</p>
                    </div>

                    <div class="col-span-2 text-center">
                        @php
                            $status = strtolower($order->status);
                            $bg = 'bg-gray-100';
                            $text = 'text-gray-700';

                            if ($status === 'pending') {
                                $bg = 'bg-orange-100';
                                $text = 'text-orange-700';
                            } elseif ($status === 'paid') {
                                $bg = 'bg-green-100';
                                $text = 'text-green-700';
                            } elseif ($status === 'canceled') {
                                $bg = 'bg-red-100';
                                $text = 'text-red-700';
                            } elseif ($status === 'done') {
                                $bg = 'bg-blue-100';
                                $text = 'text-blue-700';
                            }
                        @endphp
                        <span class="px-3 py-1 text-xs font-bold rounded-full {{ $bg }} {{ $text }} uppercase tracking-wider">
                            {{ $status }}
                        </span>
                    </div>

                    <div class="col-span-1 flex justify-end relative" x-data="{ open: false }" @click.away="open = false">
                        <button @click="open = !open" class="text-gray-400 hover:text-gray-600 p-2 focus:outline-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z" />
                            </svg>
                        </button>
                        <div x-show="open" style="display: none;" class="absolute right-0 top-10 w-40 bg-white rounded-xl shadow-xl border border-gray-100 py-2 z-50">
                            <a href="{{ route('admin.orders.show', $order->id) }}"
                               class="flex items-center gap-2 px-4 py-2 text-sm font-semibold text-brand-700 hover:bg-brand-50 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                Detail
                            </a>
                            @if(strtolower($order->status) === 'pending')
                                <a href="{{ route('admin.orders.edit', $order->id) }}" class="flex items-center gap-2 px-4 py-2 text-sm font-semibold text-blue-600 hover:bg-blue-50 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                    </svg>
                                    Edit
                                </a>
                                <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="canceled">
                                    <button type="submit" onclick="return confirm('Cancel pesanan ini?')" class="w-full flex items-center gap-2 text-left px-4 py-2 text-sm font-semibold text-orange-600 hover:bg-orange-50 transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                        Cancel Payment
                                    </button>
                                </form>
                            @endif
                            @if(strtolower($order->status) === 'paid')
                                <form action="{{ route('admin.orders.confirmReturn', $order->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" onclick="return confirm('Konfirmasi pengembalian? Stok akan bertambah kembali.')" class="w-full flex items-center gap-2 text-left px-4 py-2 text-sm font-semibold text-green-600 hover:bg-green-50 transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                        Konfirmasi Pengembalian Kostum
                                    </button>
                                </form>
                            @endif
                            <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        onclick="return confirm('Hapus pesanan ini?')"
                                        class="w-full flex items-center gap-2 text-left px-4 py-2 text-sm font-semibold text-red-600 hover:bg-red-50 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
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
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                    <p class="text-gray-500 text-sm font-medium">Belum ada transaksi penyewaan.</p>
                    <a href="{{ route('admin.orders.create') }}"
                       class="mt-3 inline-flex items-center text-sm font-semibold text-brand-600 hover:text-brand-800">
                        + Tambah sekarang
                    </a>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<script src="//unpkg.com/alpinejs" defer></script>
@endsection
