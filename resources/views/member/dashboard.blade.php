@extends('layouts.member')

@section('title', 'Dashboard - ' . config('app.name'))

@section('content')
<div class="space-y-8">

    {{-- Hero Section --}}
    <div class="bg-[#e2e8d3] rounded-3xl p-8 relative overflow-hidden flex flex-col md:flex-row items-center justify-between shadow-sm">
        <div class="z-10 relative space-y-4">
            <h2 class="text-3xl md:text-4xl font-extrabold text-[#5c6e46]">
                Welcome back, {{ auth()->user()->username ?? 'Member' }}!
            </h2>
            <p class="text-[#72855a] font-medium text-lg">
                Your costume for the upcoming "Anime Expo 2024" is ready...
            </p>
            <button class="bg-[#859873] hover:bg-[#6c7d5c] text-white font-semibold py-3 px-6 rounded-full transition-colors inline-block mt-4 shadow-md">
                Cek Event
            </button>
        </div>

        {{-- Decorative Stars --}}
        <div class="absolute right-10 top-10 opacity-50 hidden md:block z-0">
            <svg class="w-24 h-24 text-[#9cae88]" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
            </svg>
        </div>
        <div class="absolute right-40 bottom-5 opacity-30 hidden md:block z-0">
            <svg class="w-16 h-16 text-[#9cae88]" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
            </svg>
        </div>
    </div>

    {{-- Featured Costumes --}}
    <div>
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-2xl font-bold text-gray-800">Featured Costumes</h3>
            <a href="{{ route('member.costums.index') }}" class="text-[#859873] font-semibold hover:underline">View All</a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($featuredCostumes as $costum)
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden relative group flex flex-col">
                <a href="{{ route('member.costums.show', $costum->id) }}" class="absolute inset-0 z-10"></a>
                <div class="absolute top-3 left-3 bg-[#e2e8d3] text-[#5c6e46] text-xs font-bold px-3 py-1 rounded-full z-20">
                    NEW
                </div>

                <div class="h-64 w-full bg-gray-100 relative overflow-hidden group">
                    @if($costum->photo_url)
                        <img src="{{ Storage::url($costum->photo_url) }}" alt="{{ $costum->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-gray-400">No Image</div>
                    @endif
                </div>

                <div class="p-4 flex-grow flex flex-col justify-between">
                    <div>
                        <h4 class="font-bold text-gray-800 text-lg truncate" title="{{ $costum->name }}">{{ $costum->name }}</h4>
                        <p class="text-sm text-gray-500 mb-1 truncate" title="{{ $costum->name_anime }}">{{ $costum->name_anime }}</p>
                        @if($costum->nama_cosplayer)
                        <p class="text-xs text-gray-400 mb-1 truncate" title="{{ $costum->nama_cosplayer }}">Cosplayer: {{ $costum->nama_cosplayer }}</p>
                        @endif
                        <p class="text-xs font-semibold {{ $costum->stock > 0 ? 'text-green-600' : 'text-red-500' }} mb-2">
                            Sisa Stok: {{ $costum->stock }}
                        </p>
                        @if($costum->lokasi)
                        <p class="text-xs text-gray-500 mb-2 truncate" title="{{ $costum->lokasi }}">
                            <svg class="w-3 h-3 inline-block -mt-0.5 mr-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            {{ $costum->lokasi }}
                        </p>
                        @endif
                    </div>
                    <div class="flex items-center justify-between mt-auto pt-2 border-t border-gray-50">
                        <span class="font-bold text-[#859873]">Rp {{ number_format($costum->priceday, 0, ',', '.') }} <span class="text-xs text-gray-400 font-normal">/ 3 hari</span></span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    {{-- Bottom Section: Recent Rentals & Upcoming Events --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

        {{-- Recent Rentals --}}
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100">
            <h3 class="text-xl font-bold text-gray-800 mb-6">Recent Rentals</h3>

            <div class="space-y-4">
                @forelse($recentRentals as $order)
                @php
                    $firstItem = $order->items->first();
                    $costum = $firstItem ? $firstItem->costum : null;
                    $statusClass = in_array(strtolower($order->status), ['done', 'completed']) ? 'bg-green-100 text-green-700' : 'bg-blue-100 text-blue-700';
                    $statusText = in_array(strtolower($order->status), ['done', 'canceled', 'completed']) ? 'Completed' : 'Active';
                @endphp

                @if($costum)
                <div class="flex items-center gap-4 p-4 border border-gray-100 rounded-2xl hover:bg-gray-50 transition-colors">
                    <div class="h-16 w-16 rounded-xl overflow-hidden bg-gray-100 flex-shrink-0">
                        @if($costum->photo_url)
                            <img src="{{ Storage::url($costum->photo_url) }}" alt="{{ $costum->name }}" class="w-full h-full object-cover">
                        @endif
                    </div>
                    <div class="flex-grow min-w-0">
                        <h4 class="font-bold text-gray-800 truncate" title="{{ $costum->name }}">{{ $costum->name }}</h4>
                        <p class="text-xs text-gray-500">Returned on {{ \Carbon\Carbon::parse($order->tgl_pengembalian)->format('d M Y') }}</p>
                        <p class="text-xs text-gray-400 mt-1">Code: {{ $order->code_booking }}</p>
                    </div>
                    <div class="flex-shrink-0 text-right">
                        <span class="inline-block px-3 py-1 text-xs font-bold rounded-full {{ $statusClass }}">
                            {{ $statusText }}
                        </span>
                    </div>
                </div>
                @endif
                @empty
                <div class="text-center py-8 text-gray-500 bg-gray-50 rounded-2xl">
                    <p>No recent rentals found.</p>
                </div>
                @endforelse
            </div>
        </div>

        {{-- Upcoming Events --}}
        <div class="bg-[#9cae88] rounded-3xl p-6 shadow-sm text-white relative overflow-hidden">
            <div class="relative z-10">
                <h3 class="text-xl font-bold mb-6">Upcoming Events</h3>

                <div class="space-y-4">
                    @foreach($upcomingEvents as $event)
                    <div class="flex items-center gap-4 bg-white/10 backdrop-blur-sm border border-white/20 p-4 rounded-2xl hover:bg-white/20 transition-colors">
                        <div class="bg-white text-[#9cae88] rounded-xl p-3 flex flex-col items-center justify-center min-w-[70px] shadow-sm">
                            <span class="text-xs font-bold uppercase">{{ explode(' ', $event['date'])[1] }}</span>
                            <span class="text-xl font-extrabold">{{ explode(' ', $event['date'])[0] }}</span>
                        </div>
                        <div class="flex-grow min-w-0">
                            <h4 class="font-bold text-lg truncate" title="{{ $event['title'] }}">{{ $event['title'] }}</h4>
                            <p class="text-sm text-[#e2e8d3] truncate" title="{{ $event['location'] }}">
                                <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                {{ $event['location'] }}
                            </p>
                        </div>
                        <div class="flex-shrink-0">
                            <button class="bg-white text-[#859873] text-xs font-bold px-4 py-2 rounded-full hover:bg-[#e2e8d3] transition-colors shadow-sm">
                                JOIN
                            </button>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Decorative Elements --}}
            <div class="absolute -right-10 -bottom-10 opacity-20 z-0">
                <svg class="w-48 h-48" fill="currentColor" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="10" />
                </svg>
            </div>
        </div>

    </div>

</div>
@endsection
