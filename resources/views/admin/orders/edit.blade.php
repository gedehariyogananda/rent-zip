@extends('layouts.admin')

@section('content')
<div class="mb-8 flex items-center justify-between">
    <div>
        <h1 class="text-3xl font-bold text-brand-800 mb-2">Edit Transaksi Sewa</h1>
        <p class="text-gray-500">Edit pesanan {{ $order->code_booking }} (Masih Pending).</p>
    </div>
    <a href="{{ route('admin.orders.show', $order->id) }}" class="flex items-center px-4 py-2 bg-white border border-gray-200 rounded-xl text-sm font-medium text-gray-600 hover:bg-gray-50 transition-colors shadow-sm">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
        Batal Edit
    </a>
</div>

<div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden" x-data="orderForm()">

    @if(session('error'))
        <div class="m-6 p-4 rounded-xl bg-red-50 text-red-600 text-sm font-semibold flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
            </svg>
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('admin.orders.update', $order->id) }}" method="POST" class="p-8">
        @csrf
        @method('PUT')

        {{-- Section 1: Customer Details (Read Only) --}}
        <div class="mb-10">
            <h3 class="text-lg font-bold text-gray-800 mb-6 pb-2 border-b border-gray-100">1. Data Pelanggan</h3>
            <div class="p-6 bg-gray-50 rounded-2xl border border-gray-100 flex items-center gap-4">
                <div class="w-12 h-12 rounded-full bg-brand-100 text-brand-700 flex items-center justify-center flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-bold text-gray-800">{{ $order->user->username ?? 'Pelanggan Dihapus' }}</p>
                    <p class="text-xs text-gray-500">{{ $order->user->phone ?? '-' }}</p>
                </div>
            </div>
            <p class="text-xs text-gray-400 mt-2">*Data pelanggan tidak dapat diubah pada saat mengedit pesanan.</p>
        </div>

        {{-- Section 2: Rental Dates --}}
        <div class="mb-10">
            <h3 class="text-lg font-bold text-gray-800 mb-6 pb-2 border-b border-gray-100">2. Jadwal Sewa</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-2xl">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Tanggal Mulai Sewa <span class="text-red-500">*</span></label>
                    <input type="date" name="tgl_sewa" x-model="tglSewa" @change="calculateTotal" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-brand-500" required>
                    @error('tgl_sewa') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Tanggal Pengembalian <span class="text-red-500">*</span></label>
                    <input type="date" name="tgl_pengembalian" x-model="tglKembali" @change="calculateTotal" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-brand-500" required>
                    @error('tgl_pengembalian') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        {{-- Section 3: Costumes --}}
        <div class="mb-10">
            <div class="flex justify-between items-center mb-6 pb-2 border-b border-gray-100">
                <h3 class="text-lg font-bold text-gray-800">3. Daftar Kostum</h3>
                <button type="button" @click="addCostume" class="px-4 py-2 bg-brand-100 text-brand-700 hover:bg-brand-200 rounded-xl text-sm font-bold transition-colors shadow-sm">
                    + Tambah Kostum
                </button>
            </div>

            <div class="space-y-4">
                <template x-for="(item, index) in items" :key="index">
                    <div class="flex items-end gap-4 p-4 border border-gray-200 rounded-2xl bg-white">
                        <div class="flex-grow">
                            <label class="block text-sm font-bold text-gray-700 mb-2">Pilih Kostum <span class="text-red-500">*</span></label>
                            <select x-model="item.id" @change="updatePrice(index, $event)" :name="`costums[${index}][id]`" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-brand-500" required>
                                <option value="">-- Pilih Kostum --</option>
                                @foreach($costums as $costum)
                                    <option value="{{ $costum->id }}" data-price="{{ $costum->priceday }}" {{ $costum->available_stock <= 0 ? 'disabled' : '' }}>
                                        {{ $costum->name }} - Rp {{ number_format($costum->priceday, 0, ',', '.') }}/3 Hari (Sisa: {{ $costum->available_stock }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="w-32">
                            <label class="block text-sm font-bold text-gray-700 mb-2">Jumlah <span class="text-red-500">*</span></label>
                            <input type="number" x-model="item.pcs" @input="calculateTotal" :name="`costums[${index}][pcs]`" min="1" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 text-center" required>
                        </div>
                        <div class="pb-1">
                            <button type="button" @click="removeCostume(index)" class="p-3 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-xl transition-colors" title="Hapus baris">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </template>
            </div>

            <div class="mt-8 p-6 bg-brand-50 rounded-2xl flex flex-col md:flex-row justify-between items-center gap-4">
                <div>
                    <p class="text-sm font-medium text-brand-700 mb-1">Durasi Sewa</p>
                    <p class="text-xl font-bold text-brand-900"><span x-text="days"></span> Hari</p>
                </div>
                <div class="text-right">
                    <p class="text-sm font-medium text-brand-700 mb-1">Estimasi Total Harga</p>
                    <p class="text-3xl font-black text-brand-900" x-text="'Rp ' + formatRupiah(grandTotal)"></p>
                </div>
            </div>
        </div>

        <div class="pt-6 border-t border-gray-100 flex items-center justify-end gap-4">
            <button type="submit" class="flex items-center px-8 py-3 bg-brand-700 hover:bg-brand-800 text-white rounded-xl text-sm font-bold transition-colors shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                </svg>
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>

<script src="//unpkg.com/alpinejs" defer></script>
<script>
    function orderForm() {
        return {
            tglSewa: '{{ $order->tgl_sewa->format("Y-m-d") }}',
            tglKembali: '{{ $order->tgl_pengembalian->format("Y-m-d") }}',
            days: 0,
            grandTotal: 0,
            items: @json($order->items->map(function($item) {
                return [
                    'id' => (string) $item->costum_id,
                    'pcs' => $item->pcs,
                    'price' => $item->costum ? $item->costum->priceday : 0
                ];
            })),
            init() {
                this.calculateTotal();
            },
            addCostume() {
                this.items.push({ id: '', pcs: 1, price: 0 });
                this.calculateTotal();
            },
            removeCostume(index) {
                if (this.items.length > 1) {
                    this.items.splice(index, 1);
                    this.calculateTotal();
                }
            },
            updatePrice(index, event) {
                const selectElement = event ? event.target : null;
                if(selectElement) {
                    const selectedOption = selectElement.options[selectElement.selectedIndex];
                    const price = selectedOption.getAttribute('data-price') || 0;
                    this.items[index].price = parseFloat(price);
                }
                this.calculateTotal();
            },
            calculateTotal() {
                this.days = 3;
                if (this.tglSewa) {
                    const start = new Date(this.tglSewa);
                    let diffDays = 3;

                    if (this.tglKembali) {
                        const end = new Date(this.tglKembali);
                        if (end >= start) {
                            const diffTime = Math.abs(end - start);
                            diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
                        }
                    }

                    let multipleOf3 = Math.ceil(diffDays / 3) * 3;
                    if (multipleOf3 === 0) multipleOf3 = 3;
                    this.days = multipleOf3;

                    const newEnd = new Date(start);
                    newEnd.setDate(newEnd.getDate() + this.days);
                    const year = newEnd.getFullYear();
                    const month = String(newEnd.getMonth() + 1).padStart(2, '0');
                    const day = String(newEnd.getDate()).padStart(2, '0');
                    this.tglKembali = `${year}-${month}-${day}`;
                }

                this.grandTotal = this.items.reduce((total, item) => {
                    return total + (item.price * Math.ceil(this.days / 3) * item.pcs);
                }, 0);
            },
            formatRupiah(angka) {
                return new Intl.NumberFormat('id-ID').format(angka);
            }
        }
    }
</script>
@endsection
