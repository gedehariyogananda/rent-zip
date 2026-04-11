@extends('layouts.member')

@section('title', 'Events')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-[#1a331a]">Live Events</h1>
            <p class="text-gray-500 mt-1 text-sm md:text-base">Curated conventions and costume showcases.</p>
        </div>

        <!-- Toggle Filters -->
        <div class="flex bg-gray-50 p-1.5 rounded-xl border border-gray-100">
            <a href="{{ route('member.events.index', ['status' => 'all']) }}"
               class="px-5 py-2 rounded-lg text-sm font-bold transition-all {{ $status === 'all' ? 'bg-white text-[#1a331a] shadow-sm' : 'text-gray-400 hover:text-gray-600' }}">
                All Events
            </a>
            <a href="{{ route('member.events.index', ['status' => 'archived']) }}"
               class="px-5 py-2 rounded-lg text-sm font-bold transition-all {{ $status === 'archived' ? 'bg-white text-[#1a331a] shadow-sm' : 'text-gray-400 hover:text-gray-600' }}">
                Archived
            </a>
        </div>
    </div>

    <!-- Events Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        @forelse($events as $event)
            <!-- Event Card -->
            <div class="bg-white rounded-[1.5rem] overflow-hidden shadow-sm border border-gray-100 flex flex-col hover:shadow-md transition-shadow duration-300 group cursor-pointer">
                <!-- Banner Image -->
                <div class="relative h-56 w-full bg-gray-900 overflow-hidden">
                    @if($event->image_url)
                        <img src="{{ Storage::url($event->image_url) }}" alt="{{ $event->name }}" class="w-full h-full object-cover opacity-90 group-hover:scale-105 transition-transform duration-500">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-gray-600 bg-gray-800">
                            <svg class="w-8 h-8 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                    @endif

                    <!-- Status Badge -->
                    <div class="absolute bottom-4 left-4">
                        @if($event->date >= \Carbon\Carbon::today())
                            <span class="bg-[#dcfce7] text-[#166534] px-3 py-1.5 rounded-lg text-[10px] font-extrabold tracking-wider uppercase shadow-sm">
                                AVAILABLE
                            </span>
                        @else
                            <span class="bg-gray-200 text-gray-700 px-3 py-1.5 rounded-lg text-[10px] font-extrabold tracking-wider uppercase shadow-sm">
                                ARCHIVED
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Event Info -->
                <div class="p-6 flex flex-col grow">
                    <h3 class="text-[1.15rem] font-bold text-[#1a331a] mb-3 leading-snug line-clamp-2">
                        {{ $event->name }}
                    </h3>

                    <div class="flex items-center text-sm text-gray-500 mb-6 gap-2.5">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <span class="font-medium">{{ $event->date->format('M d, Y') }}</span>
                    </div>

                    <!-- Location Footer -->
                    <div class="mt-auto pt-4 border-t border-gray-50 flex items-center justify-between text-sm text-gray-600">
                        <div class="flex items-center gap-2 truncate pr-4">
                            <svg class="w-4 h-4 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <span class="truncate font-medium">{{ $event->location }}</span>
                        </div>
                        <svg class="w-5 h-5 text-gray-400 shrink-0 group-hover:text-[#1a331a] group-hover:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full py-20 text-center">
                <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-gray-50 mb-4">
                    <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-1">No events found</h3>
                <p class="text-gray-500">There are currently no {{ $status === 'archived' ? 'archived' : 'upcoming' }} events to display.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection
