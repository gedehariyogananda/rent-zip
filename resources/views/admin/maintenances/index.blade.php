@extends('layouts.admin')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-brand-800 mb-2">Manajemen Stok & Log</h1>
    <p class="text-gray-500">Track penambahan dan pengurangan (maintenance/rusak) stok kostum.</p>
</div>

<div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
    {{-- Header: filter + tambah --}}
    <div class="p-6 border-b border-gray-50 flex flex-col xl:flex-row xl:items-center justify-between gap-4">
        <h2 class="text-xl font-bold text-gray-800">Riwayat Stok</h2>

        <div class="flex flex-col sm:flex-row gap-3">
            <form action="{{ route('admin.maintenances.index') }}" method="GET" class="flex gap-2">
                <select name="costum_id" onchange="this.form.submit()"
                        class="px-4 py-2 border border-gray-200 rounded-xl text-sm text-gray-600 focus:outline-none focus:ring-2 focus:ring-brand-500 w-full sm:w-auto">
                    <option value="">Semua Kostum</option>
                    @foreach($costums as $costum)
                        <option value="{{ $costum->id }}" {{ ($filters['costum_id'] ?? '') == $costum->id ? 'selected' : '' }}>
                            {{ $costum->name }}
                        </option>
                    @endforeach
                </select>

                <select name="type" onchange="this.form.submit()"
                        class="px-4 py-2 border border-gray-200 rounded-xl text-sm text-gray-600 focus:outline-none focus:ring-2 focus:ring-brand-500 w-full sm:w-auto">
                    <option value="">Semua Tipe</option>
                    <option value="penambahan" {{ ($filters['type'] ?? '') === 'penambahan' ? 'selected' : '' }}>Penambahan</option>
                    <option value="pengurangan" {{ ($filters['type'] ?? '') === 'pengurangan' ? 'selected' : '' }}>Pengurangan</option>
                </select>

                @if(!empty($filters['costum_id']) || !empty($filters['type']))
                    <a href="{{ route('admin.maintenances.index') }}"
                       class="px-4 py-2 text-sm font-semibold text-gray-500 hover:text-gray-700 flex items-center">Reset</a>
                @endif
            </form>

            <a href="{{ route('admin.maintenances.create') }}"
               class="flex items-center justify-center gap-2 px-5 py-2.5 bg-brand-700 hover:bg-brand-800 text-white rounded-xl text-sm font-bold transition-colors shadow-sm whitespace-nowrap">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Log Stok
            </a>
        </div>
    </div>

    <div class="p-6 overflow-x-auto">
        {{-- Table Header --}}
        <div class="min-w-[800px] grid grid-cols-12 gap-4 pb-4 border-b border-gray-50 text-xs font-bold text-gray-400 uppercase tracking-wider px-4">
            <div class="col-span-2">TANGGAL</div>
            <div class="col-span-3">KOSTUM</div>
            <div class="col-span-2">TIPE</div>
            <div class="col-span-3">KATEGORI & DESKRIPSI</div>
            <div class="col-span-1 text-center">JUMLAH</div>
            <div class="col-span-1 text-right">AKSI</div>
        </div>

        {{-- Table Body --}}
        <div class="min-w-[800px] space-y-3 mt-4">
            @forelse($maintenances as $maintenance)
            <div class="grid grid-cols-12 gap-4 items-center p-4 bg-gray-50/50 rounded-xl hover:bg-gray-50 transition-colors">

                <div class="col-span-2 text-sm font-semibold text-gray-700">
                    {{ \Carbon\Carbon::parse($maintenance->created_at)->translatedFormat('d M Y, H:i') }}
                </div>

                <div class="col-span-3">
                    <p class="text-sm font-bold text-gray-800 line-clamp-1">{{ $maintenance->costum->name ?? 'Kostum Dihapus' }}</p>
                    <p class="text-xs text-gray-500">Stok saat proses: <span class="font-semibold text-brand-600">{{ $maintenance->current_stock ?? ($maintenance->costum->stock ?? 0) }}</span></p>
                </div>

                <div class="col-span-2">
                    @if($maintenance->type === 'penambahan')
                        <span class="inline-flex px-3 py-1 rounded-full text-[10px] font-bold bg-[#d4edda] text-green-800 uppercase tracking-wider">
                            Penambahan
                        </span>
                    @else
                        <span class="inline-flex px-3 py-1 rounded-full text-[10px] font-bold bg-[#ffccbc] text-red-800 uppercase tracking-wider">
                            Pengurangan
                        </span>
                    @endif
                </div>

                <div class="col-span-3">
                    @if($maintenance->type === 'pengurangan' && $maintenance->category)
                        <span class="inline-block px-2 py-0.5 bg-gray-200 text-gray-700 text-[10px] font-bold rounded mb-1 uppercase tracking-wider">
                            {{ $maintenance->category->name }}
                        </span>
                    @endif
                    <p class="text-sm text-gray-500 line-clamp-2" title="{{ $maintenance->desc }}">
                        {{ $maintenance->desc ?? '-' }}
                    </p>
                </div>

                <div class="col-span-1 text-center">
                    <span class="text-sm font-bold {{ $maintenance->type === 'penambahan' ? 'text-green-600' : 'text-red-600' }}">
                        {{ $maintenance->type === 'penambahan' ? '+' : '-' }}{{ $maintenance->pcs }}
                    </span>
                </div>

                <div class="col-span-1 flex justify-end">
                    <form action="{{ route('admin.maintenances.destroy', $maintenance->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                onclick="return confirm('Apakah Anda yakin ingin menghapus log ini? Menghapus log ini akan melakukan ROLLBACK (mengembalikan) stok kostum seperti sebelum log ini dibuat.')"
                                class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors focus:outline-none"
                                title="Hapus log dan kembalikan stok">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </button>
                    </form>
                </div>

            </div>
            @empty
            <div class="py-16 text-center">
                <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-gray-100 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                    </svg>
                </div>
                <p class="text-gray-500 text-sm font-medium">Belum ada riwayat stok kostum.</p>
                <a href="{{ route('admin.maintenances.create') }}"
                   class="mt-3 inline-flex items-center text-sm font-semibold text-brand-600 hover:text-brand-800">
                    + Tambah log stok sekarang
                </a>
            </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        <div class="mt-6 pt-6 border-t border-gray-50 flex flex-col gap-6">
            <div class="w-full overflow-x-auto">
                {{ $maintenances->withQueryString()->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
