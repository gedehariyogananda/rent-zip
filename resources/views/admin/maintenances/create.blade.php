@extends('layouts.admin')

@section('content')
<div class="mb-8 flex items-center justify-between">
    <div>
        <h1 class="text-3xl font-bold text-brand-800 mb-2">Tambah Log Stok</h1>
        <p class="text-gray-500">Catat riwayat penambahan atau pengurangan (maintenance) stok kostum.</p>
    </div>
    <a href="{{ route('admin.maintenances.index') }}" class="flex items-center px-4 py-2 bg-white border border-gray-200 rounded-xl text-sm font-medium text-gray-600 hover:bg-gray-50 transition-colors shadow-sm">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
        Kembali
    </a>
</div>

<div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden max-w-3xl">
    <div class="p-8">
        <form action="{{ route('admin.maintenances.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Kostum -->
            <div>
                <label for="costum_id" class="block text-sm font-bold text-gray-700 mb-2">Pilih Kostum <span class="text-red-500">*</span></label>
                <select name="costum_id" id="costum_id"
                        class="block w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 focus:border-brand-500 focus:bg-white transition-colors"
                        required onchange="validateStock()">
                    <option value="" disabled {{ old('costum_id') ? '' : 'selected' }}>Pilih Kostum...</option>
                    @foreach($costums as $costum)
                        <option value="{{ $costum->id }}" data-stock="{{ $costum->stock }}" {{ old('costum_id') == $costum->id ? 'selected' : '' }}>
                            {{ $costum->name }} (Stok saat ini: {{ $costum->stock }})
                        </option>
                    @endforeach
                </select>
                @error('costum_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Tipe Log -->
            <div>
                <label for="type_select" class="block text-sm font-bold text-gray-700 mb-2">Tipe Perubahan <span class="text-red-500">*</span></label>
                <select name="type" id="type_select" onchange="toggleCategory(); validateStock()"
                        class="block w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 focus:border-brand-500 focus:bg-white transition-colors"
                        required>
                    <option value="" disabled {{ old('type') ? '' : 'selected' }}>Pilih Tipe Perubahan...</option>
                    <option value="penambahan" {{ old('type') == 'penambahan' ? 'selected' : '' }}>Penambahan Stok</option>
                    <option value="pengurangan" {{ old('type') == 'pengurangan' ? 'selected' : '' }}>Pengurangan Stok (Rusak/Hilang/Maintenance)</option>
                </select>
                @error('type')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Jumlah -->
            <div>
                <label for="pcs" class="block text-sm font-bold text-gray-700 mb-2">Jumlah (Pcs) <span class="text-red-500">*</span></label>
                <input type="number" name="pcs" id="pcs"
                       value="{{ old('pcs', 1) }}"
                       min="1" step="1"
                       placeholder="Masukkan jumlah..."
                       class="block w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 focus:border-brand-500 focus:bg-white transition-colors"
                       required oninput="validateStock()">
                <p id="pcs-error" class="mt-1 text-sm font-medium text-red-600 hidden">Jumlah pengurangan melebihi stok yang tersedia.</p>
                @error('pcs')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Kategori Pengurangan (Hidden by default) -->
            <div id="category_wrapper" class="hidden">
                <label for="category_id" class="block text-sm font-bold text-gray-700 mb-2">Alasan Pengurangan (Kategori) <span class="text-red-500">*</span></label>
                <select name="category_id" id="category_id"
                        class="block w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 focus:border-brand-500 focus:bg-white transition-colors">
                    <option value="" disabled {{ old('category_id') ? '' : 'selected' }}>Pilih Alasan Pengurangan...</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <p class="text-xs text-gray-500 mt-2">Kategori ini hanya diperlukan saat Anda melakukan pengurangan stok kostum.</p>
            </div>

            <!-- Deskripsi -->
            <div>
                <label for="desc" class="block text-sm font-bold text-gray-700 mb-2">Deskripsi / Catatan</label>
                <textarea name="desc" id="desc" rows="4"
                          placeholder="Contoh: Kostum dikirim ke laundry, atau restock dari supplier..."
                          class="block w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 focus:border-brand-500 focus:bg-white transition-colors resize-none">{{ old('desc') }}</textarea>
                @error('desc')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="pt-4 flex items-center justify-end gap-4 border-t border-gray-100">
                <a href="{{ route('admin.maintenances.index') }}" class="px-6 py-3 text-sm font-bold text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-xl transition-colors">
                    Batal
                </a>
                <button type="submit" id="submit-btn" class="flex items-center px-6 py-3 bg-brand-700 hover:bg-brand-800 text-white rounded-xl text-sm font-bold transition-colors shadow-sm disabled:opacity-50 disabled:cursor-not-allowed">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                    </svg>
                    Simpan Log Stok
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function toggleCategory() {
        const typeSelect = document.getElementById('type_select');
        const categoryWrapper = document.getElementById('category_wrapper');

        if (typeSelect.value === 'pengurangan') {
            categoryWrapper.classList.remove('hidden');
        } else {
            categoryWrapper.classList.add('hidden');
        }
    }

    function validateStock() {
        const costumSelect = document.getElementById('costum_id');
        const typeSelect = document.getElementById('type_select');
        const pcsInput = document.getElementById('pcs');
        const errorText = document.getElementById('pcs-error');
        const submitBtn = document.getElementById('submit-btn');

        if (!costumSelect.value || !typeSelect.value || !pcsInput.value) {
            errorText.classList.add('hidden');
            submitBtn.disabled = false;
            return;
        }

        const selectedOption = costumSelect.options[costumSelect.selectedIndex];
        const stock = parseInt(selectedOption.getAttribute('data-stock'), 10);
        const pcs = parseInt(pcsInput.value, 10);

        if (typeSelect.value === 'pengurangan' && pcs > stock) {
            errorText.classList.remove('hidden');
            pcsInput.classList.add('border-red-500', 'focus:ring-red-500', 'focus:border-red-500');
            pcsInput.classList.remove('border-gray-200', 'focus:ring-brand-500', 'focus:border-brand-500');
            submitBtn.disabled = true;
        } else {
            errorText.classList.add('hidden');
            pcsInput.classList.remove('border-red-500', 'focus:ring-red-500', 'focus:border-red-500');
            pcsInput.classList.add('border-gray-200', 'focus:ring-brand-500', 'focus:border-brand-500');
            submitBtn.disabled = false;
        }
    }

    // Run on load in case of old input errors
    document.addEventListener('DOMContentLoaded', () => {
        toggleCategory();
        validateStock();
    });
</script>
@endsection
