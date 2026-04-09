@extends('layouts.admin')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-brand-800 mb-2">Keuangan</h1>
    <p class="text-gray-500">Laporan finansial dan riwayat transaksi operasional.</p>
</div>

<!-- Summary Cards -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <!-- Keuntungan Card -->
    <div class="bg-[#d4edda] rounded-2xl p-6 relative overflow-hidden">
        <div class="flex justify-between items-start mb-8">
            <div class="w-10 h-10 bg-white/50 rounded-full flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-700" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586 14.586 7H12z" clip-rule="evenodd" />
                </svg>
            </div>
            <span class="text-xs font-bold text-green-800 bg-white/40 px-3 py-1 rounded-full tracking-wider">BULANAN</span>
        </div>
        <div>
            <p class="text-sm font-medium text-green-800 mb-1">Keuntungan</p>
            <h2 class="text-3xl font-bold text-green-900">Rp {{ number_format($keuntungan, 0, ',', '.') }}</h2>
        </div>
    </div>

    <!-- Pengeluaran Card -->
    <div class="bg-[#ff8a65] rounded-2xl p-6 relative overflow-hidden">
        <div class="flex justify-between items-start mb-8">
            <div class="w-10 h-10 bg-white/30 rounded-full flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-800" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M12 13a1 1 0 100 2h5a1 1 0 001-1V9a1 1 0 10-2 0v2.586l-4.293-4.293a1 1 0 00-1.414 0L8 9.586 3.707 5.293a1 1 0 00-1.414 1.414l5 5a1 1 0 001.414 0L11 9.414 14.586 13H12z" clip-rule="evenodd" />
                </svg>
            </div>
            <span class="text-xs font-bold text-red-900 bg-white/20 px-3 py-1 rounded-full tracking-wider">TOTAL</span>
        </div>
        <div>
            <p class="text-sm font-medium text-red-900 mb-1">Pengeluaran</p>
            <h2 class="text-3xl font-bold text-red-950">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</h2>
        </div>
    </div>

    <!-- Transaksi Card -->
    <div class="bg-[#e2eed8] rounded-2xl p-6 relative overflow-hidden">
        <div class="flex justify-between items-start mb-8">
            <div class="w-10 h-10 bg-white/50 rounded-full flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-brand-700" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd" />
                </svg>
            </div>
            <span class="text-xs font-bold text-brand-800 bg-white/40 px-3 py-1 rounded-full tracking-wider">AKTIF</span>
        </div>
        <div>
            <p class="text-sm font-medium text-brand-800 mb-1">Jumlah Transaksi</p>
            <h2 class="text-3xl font-bold text-brand-900">{{ number_format($jumlahTransaksi, 0, ',', '.') }}</h2>
        </div>
    </div>
</div>

<!-- Transaksi List -->
<div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="p-6 border-b border-gray-50 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <h2 class="text-xl font-bold text-gray-800">Riwayat Transaksi</h2>
        <form action="{{ route('admin.finances.index') }}" method="GET" class="flex gap-3">
            <select name="type" onchange="this.form.submit()" class="flex items-center px-4 py-2 bg-white border border-gray-200 rounded-lg text-sm font-medium text-gray-600 hover:bg-gray-50 focus:outline-none">
                <option value="">Semua Filter</option>
                <option value="pemasukan" {{ request('type') == 'pemasukan' ? 'selected' : '' }}>Pemasukan</option>
                <option value="pengeluaran" {{ request('type') == 'pengeluaran' ? 'selected' : '' }}>Pengeluaran</option>
            </select>
            <select name="year" onchange="this.form.submit()" class="flex items-center px-4 py-2 bg-white border border-gray-200 rounded-lg text-sm font-medium text-gray-600 hover:bg-gray-50 focus:outline-none">
                <option value="">Semua Tahun</option>
                @foreach($availableYears ?? [date('Y')] as $year)
                    <option value="{{ $year }}" {{ request('year', date('Y')) == $year ? 'selected' : '' }}>Tahun {{ $year }}</option>
                @endforeach
            </select>
        </form>
    </div>

    <div class="p-6">
        <!-- Table Header -->
        <div class="grid grid-cols-12 gap-4 pb-4 border-b border-gray-50 text-xs font-bold text-gray-400 uppercase tracking-wider px-4">
            <div class="col-span-3">TANGGAL</div>
            <div class="col-span-2">JENIS</div>
            <div class="col-span-4">DESKRIPSI</div>
            <div class="col-span-2 text-right">JUMLAH</div>
            <div class="col-span-1"></div>
        </div>

        <!-- Table Body -->
        <div class="space-y-3 mt-4">
            @forelse($finances as $finance)
            <div class="grid grid-cols-12 gap-4 items-center p-4 bg-gray-50/50 rounded-xl hover:bg-gray-50 transition-colors">
                <div class="col-span-3 text-sm font-semibold text-gray-800">
                    {{ \Carbon\Carbon::parse($finance->created_at)->translatedFormat('d M Y, H:i') }}
                </div>
                <div class="col-span-2">
                    @if($finance->type == 'pemasukan')
                        <span class="inline-flex px-3 py-1 rounded-full text-[10px] font-bold bg-[#d4edda] text-green-800 uppercase tracking-wider">
                            PEMASUKAN
                        </span>
                    @else
                        <span class="inline-flex px-3 py-1 rounded-full text-[10px] font-bold bg-[#ffccbc] text-red-800 uppercase tracking-wider">
                            PENGELUARAN
                        </span>
                    @endif
                </div>
                <div class="col-span-4 text-sm text-gray-500">
                    {{ $finance->desc }}
                </div>
                <div class="col-span-2 text-right font-bold {{ $finance->type == 'pemasukan' ? 'text-green-700' : 'text-red-700' }}">
                    Rp {{ number_format($finance->total, 0, ',', '.') }}
                </div>
                <div class="col-span-1 flex justify-end relative group">
                    <button class="text-gray-400 hover:text-gray-600 p-1 focus:outline-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z" />
                        </svg>
                    </button>
                    <!-- Dropdown menu -->
                    <div class="absolute right-0 top-8 w-32 bg-white rounded-lg shadow-lg border border-gray-100 py-1 z-10 hidden group-hover:block group-focus-within:block">
                        <a href="{{ route('admin.finances.edit', $finance->id) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Edit</a>
                        <form action="{{ route('admin.finances.destroy', $finance->id) }}" method="POST" class="block m-0">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</button>
                        </form>
                    </div>
                </div>
            </div>
            @empty
            <div class="p-8 text-center text-gray-500">
                Belum ada data transaksi.
            </div>
            @endforelse
        </div>

        <!-- Action Buttons -->
        <div class="mt-6 flex justify-end gap-3">
            <a href="{{ route('admin.finances.export', request()->query()) }}"
               class="flex items-center px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl text-sm font-bold transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                Unduh Excel
            </a>
            <a href="{{ route('admin.finances.create') }}"
               class="flex items-center px-5 py-2.5 bg-brand-700 hover:bg-brand-800 text-white rounded-xl text-sm font-bold transition-colors shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Pengeluaran
            </a>
        </div>

        <!-- Pagination -->
        <x-pagination :paginator="$finances" label="transaksi" />
    </div>
</div>
@endsection
