<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', config('app.name'))</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#f2f4ec] text-gray-800 font-sans antialiased min-h-screen flex flex-col">

    {{-- Navbar --}}
    <nav class="bg-[#9cae88] text-white rounded-b-3xl shadow-md z-10 relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">

                {{-- Left Side: Logo & Text --}}
                <div class="flex items-center gap-4">
                    <img src="{{ asset('base-images/logo-app.png') }}" alt="Logo" class="h-12 w-12 object-contain bg-white rounded-full p-1">
                    <div>
                        <h1 class="font-bold text-xl tracking-wide uppercase">{{ config('app.name') }}</h1>
                        <p class="text-xs text-[#e2e8d3] font-medium tracking-wider">SELAMAT SIANG, {{ strtoupper(auth()->user()->username ?? 'GUEST') }} / DASHBOARD</p>
                    </div>
                </div>

                {{-- Center Links --}}
                <div class="hidden md:flex space-x-8 items-center h-full">
                    <a href="{{ route('member.events.index') }}" class="text-sm font-semibold hover:text-[#f2f4ec] transition-colors h-full flex items-center border-b-2 {{ request()->routeIs('member.events.*') ? 'border-white text-white' : 'border-transparent text-gray-200 hover:text-white' }}">JADWAL EVENT</a>
                    <a href="{{ route('member.costums.index') }}" class="text-sm font-semibold hover:text-[#f2f4ec] transition-colors h-full flex items-center border-b-2 {{ request()->routeIs('member.costums.*') ? 'border-white text-white' : 'border-transparent text-gray-200 hover:text-white' }}">CARI KOSTUM</a>
                    <a href="{{ route('member.dashboard') }}" class="text-sm font-semibold transition-colors h-full flex items-center border-b-2 {{ request()->routeIs('member.dashboard') ? 'border-white text-white' : 'border-transparent text-gray-200 hover:text-white' }}">DASHBOARD</a>
                </div>

                {{-- Right Side: Profile & Logout --}}
                <div class="flex items-center gap-4">
                    <div class="text-right hidden sm:block">
                        <p class="text-sm font-bold">{{ auth()->user()->username ?? 'Guest' }}</p>
                        <p class="text-xs text-[#e2e8d3]">Premium Member</p>
                    </div>

                    {{-- Avatar & Dropdown (Simplified) --}}
                    <div class="relative group cursor-pointer">
                        <div class="h-10 w-10 rounded-full bg-white text-[#9cae88] flex items-center justify-center font-bold text-lg border-2 border-[#e2e8d3] overflow-hidden">
                            @if(auth()->user() && auth()->user()->profile_photo)
                                <img src="{{ Storage::url(auth()->user()->profile_photo) }}" alt="Avatar" class="w-full h-full object-cover">
                            @else
                                {{ substr(auth()->user()->username ?? 'G', 0, 1) }}
                            @endif
                        </div>

                        {{-- Dropdown Menu --}}
                        <div class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-20 hidden group-hover:block border border-gray-100">
                            <a href="{{ route('member.orders.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">My Orders</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </nav>

    {{-- Main Content --}}
    <main class="flex-grow max-w-7xl mx-auto w-full px-4 sm:px-6 lg:px-8 py-8">
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="bg-white border-t border-gray-200 py-6 text-center mt-auto">
        <p class="text-sm text-gray-500">&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
    </footer>

</body>
</html>
