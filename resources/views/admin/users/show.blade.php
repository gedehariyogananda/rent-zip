@extends('layouts.admin')

@section('content')
<div class="mb-8 flex items-center justify-between">
    <div class="flex items-center gap-4">
        <a href="{{ route('admin.users.index', ['role' => $user->role_id == 1 ? 'admin' : 'member']) }}" class="w-10 h-10 bg-white rounded-xl flex items-center justify-center text-gray-500 hover:text-brand-700 hover:bg-brand-50 transition-colors shadow-sm border border-gray-100">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
            </svg>
        </a>
        <div>
            <h1 class="text-3xl font-bold text-gray-800 mb-1">Detail Pengguna</h1>
            <p class="text-sm text-gray-500">Melihat detail informasi dan riwayat transaksi pengguna.</p>
        </div>
    </div>
    <a href="{{ route('admin.users.edit', $user->id) }}" class="flex items-center gap-2 px-5 py-2.5 bg-brand-700 hover:bg-brand-800 text-white rounded-xl text-sm font-bold transition-colors shadow-sm">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
            <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
        </svg>
        Edit Pengguna
    </a>
</div>

<div class="grid grid-cols-1 {{ $user->role_id == 1 ? 'max-w-xl mx-auto' : 'lg:grid-cols-3' }} gap-8">
    {{-- User Info Card --}}
    <div class="{{ $user->role_id == 1 ? 'col-span-1' : 'lg:col-span-1' }}">
        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-6 border-b border-gray-50 text-center">
                @if($user->avatar_url)
                    <img src="{{ Storage::url($user->avatar_url) }}" alt="Avatar" class="w-24 h-24 mx-auto rounded-full object-cover mb-4 border-4 border-brand-50 shadow-sm">
                @else
                    <div class="w-24 h-24 mx-auto rounded-full bg-brand-100 flex items-center justify-center text-brand-700 mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                        </svg>
                    </div>
                @endif
                <h2 class="text-xl font-bold text-gray-800">{{ $user->username }}</h2>
                <span class="inline-block mt-2 text-xs font-bold tracking-wider uppercase px-3 py-1 rounded-full {{ $user->role_id == 1 ? 'bg-purple-50 text-purple-700' : 'bg-brand-50 text-brand-700' }}">
                    {{ $user->role ? $user->role->name : 'Member' }}
                </span>
            </div>

            <div class="p-6 space-y-4">
                <div>
                    <span class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Email</span>
                    <p class="text-sm text-gray-800 font-medium">{{ $user->email }}</p>
                </div>
                <div>
                    <span class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Nomor Telepon</span>
                    <p class="text-sm text-gray-800 font-medium">{{ $user->phone ?: '-' }}</p>
                </div>
                <div>
                    <span class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Alamat</span>
                    <p class="text-sm text-gray-800 font-medium">{{ $user->address ?: '-' }}</p>
                </div>
                <div>
                    <span class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Terdaftar Sejak</span>
                    <p class="text-sm text-gray-800 font-medium">{{ $user->created_at ? $user->created_at->format('d M Y') : '-' }}</p>
                </div>
                @if($user->role_id != 1 && $user->profile)
                <div class="pt-4 border-t border-gray-50 space-y-4">
                    <div>
                        <span class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Nomor Darurat</span>
                        <p class="text-sm text-gray-800 font-medium">{{ $user->profile->no_darurat ?: 'Belum diisi' }}</p>
                    </div>

                    <div>
                        <span class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">KTP</span>
                        @if($user->profile->ktp_url)
                            <a href="{{ Storage::url($user->profile->ktp_url) }}" target="_blank" class="text-brand-600 hover:text-brand-700 text-sm font-medium flex items-center gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd" />
                                </svg>
                                Lihat Dokumen KTP
                            </a>
                        @else
                            <p class="text-sm text-gray-500 font-medium">Belum diunggah</p>
                        @endif
                    </div>

                    <div>
                        <span class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">NIK</span>
                        <p class="text-sm text-gray-800 font-medium">{{ $user->profile->nik ?: 'Belum diisi' }}</p>
                    </div>

                    <div>
                        <span class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Foto dengan NIK</span>
                        @if($user->profile->photo_with_nik)
                            <a href="{{ Storage::url($user->profile->photo_with_nik) }}" target="_blank" class="text-brand-600 hover:text-brand-700 text-sm font-medium flex items-center gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd" />
                                </svg>
                                Lihat Foto NIK
                            </a>
                        @else
                            <p class="text-sm text-gray-500 font-medium">Belum diunggah</p>
                        @endif
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    @if($user->role_id != 1)
    {{-- Order History Card --}}
    <div class="lg:col-span-2">
        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden h-full">
            <div class="p-6 border-b border-gray-50 flex items-center justify-between">
                <h2 class="text-xl font-bold text-gray-800">Riwayat Pesanan</h2>
                <span class="text-xs font-bold tracking-wider uppercase px-3 py-1 rounded-full bg-brand-50 text-brand-700">
                    {{ $user->orders->count() }} Transaksi
                </span>
            </div>

            <div class="p-6">
                @if($user->orders->count() > 0)
                    <div class="space-y-4">
                        @foreach($user->orders as $order)
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-2xl hover:bg-gray-100 transition-colors border border-transparent hover:border-gray-200">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-xl bg-white shadow-sm flex items-center justify-center text-brand-600 flex-shrink-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-bold text-gray-800">{{ $order->code_booking ?? 'TRX-'.$order->id }}</h3>
                                    <div class="flex items-center gap-2 mt-1">
                                        <span class="text-xs font-medium text-gray-500">{{ $order->created_at ? $order->created_at->format('d M Y, H:i') : '-' }}</span>
                                        <span class="text-gray-300">•</span>
                                        <span class="text-xs font-bold text-gray-700">Rp {{ number_format($order->total ?? $order->total_amount ?? 0, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center gap-4">
                                @php
                                    $status = strtolower($order->status ?? 'pending');
                                    $statusClass = 'bg-gray-100 text-gray-700';
                                    if(in_array($status, ['pending', 'unpaid'])) $statusClass = 'bg-orange-100 text-orange-700';
                                    if(in_array($status, ['success', 'paid', 'completed'])) $statusClass = 'bg-green-100 text-green-700';
                                    if(in_array($status, ['failed', 'cancelled'])) $statusClass = 'bg-red-100 text-red-700';
                                @endphp
                                <span class="px-3 py-1 text-xs font-bold rounded-full {{ $statusClass }}">
                                    {{ ucfirst($status) }}
                                </span>
                                <a href="{{ route('admin.orders.show', $order->id) }}" class="p-2 text-gray-400 hover:text-brand-700 hover:bg-brand-50 rounded-lg transition-colors" title="Lihat Detail">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="py-12 text-center">
                        <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-gray-50 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </div>
                        <h3 class="text-sm font-bold text-gray-700 mb-1">Belum Ada Transaksi</h3>
                        <p class="text-sm text-gray-500">Pengguna ini belum melakukan pesanan apa pun.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
    @endif
</div>
@endsection
