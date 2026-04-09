@extends('layouts.auth')

@section('title', 'Register')

@section('content')
<div class="flex min-h-screen">
    <!-- Left Side: Image & Branding -->
    <div class="hidden lg:flex lg:w-1/2 relative bg-brand-900 overflow-hidden flex-col justify-between p-12 text-white"
         style="background-image: url('{{ asset('base-images/register-screen.png') }}'); background-size: cover; background-position: center;">

        <!-- Overlay -->
        <div class="absolute inset-0 bg-black/40 bg-gradient-to-t from-brand-900/90 to-transparent"></div>

        <!-- Content -->
        <div class="relative z-10">
            <div class="flex items-center gap-3 mb-12">
                <div class="w-10 h-10 bg-brand-100 text-brand-700 rounded-lg flex items-center justify-center font-bold text-xl">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <span class="font-bold text-xl tracking-wide">Noctaringems Cosrent</span>
            </div>

            <h1 class="text-5xl font-bold leading-tight mb-6">
                Selamat Datang di<br>Rental Kostum<br>Noctoriagoras
            </h1>

            <p class="text-lg text-gray-200 mb-12 max-w-md">
                Transform into your favorite characters with our premium, artisan-crafted cosplay collection. From mystical realms to futuristic worlds.
            </p>

            <div class="flex gap-6">
                <div class="bg-white/10 backdrop-blur-sm border border-white/20 rounded-xl p-5 flex-1">
                    <div class="text-3xl font-bold mb-1">500+</div>
                    <div class="text-sm text-gray-300">Unique Outfits</div>
                </div>
                <div class="bg-white/10 backdrop-blur-sm border border-white/20 rounded-xl p-5 flex-1">
                    <div class="text-3xl font-bold mb-1">24h</div>
                    <div class="text-sm text-gray-300">Express Delivery</div>
                </div>
            </div>
        </div>

        <div class="relative z-10 text-xs text-gray-400 font-medium tracking-wider uppercase mt-12">
            Premium Curator System V2.4
        </div>
    </div>

    <!-- Right Side: Form -->
    <div class="w-full lg:w-1/2 flex flex-col items-center justify-center p-8 sm:p-12 lg:p-24 bg-white">
        <div class="w-full max-w-md">
            <div class="mb-10">
                <h2 class="text-3xl font-bold text-gray-900 mb-2">Create Account</h2>
                <p class="text-gray-500">Join the most exclusive community of creators and performers.</p>
            </div>

            <form method="POST" action="{{ route('register') }}" class="space-y-6">
                @csrf

                <!-- Username -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Username</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name"
                            class="block w-full pl-10 pr-3 py-3 border border-gray-200 rounded-lg bg-gray-50 text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent transition duration-150 ease-in-out"
                            placeholder="Choose a unique alias">
                    </div>
                    @error('name')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email Address -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email or Phone Number</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                            </svg>
                        </div>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username"
                            class="block w-full pl-10 pr-3 py-3 border border-gray-200 rounded-lg bg-gray-50 text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent transition duration-150 ease-in-out"
                            placeholder="name@example.com">
                    </div>
                    @error('email')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <input id="password" type="password" name="password" required autocomplete="new-password"
                            class="block w-full pl-10 pr-3 py-3 border border-gray-200 rounded-lg bg-gray-50 text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent transition duration-150 ease-in-out"
                            placeholder="••••••••">
                    </div>
                    @error('password')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Confirm Password</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                            class="block w-full pl-10 pr-3 py-3 border border-gray-200 rounded-lg bg-gray-50 text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent transition duration-150 ease-in-out"
                            placeholder="••••••••">
                    </div>
                </div>

                <!-- Terms and Privacy -->
                <div class="flex items-start">
                    <div class="flex items-center h-5">
                        <input id="terms" name="terms" type="checkbox" required class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-brand-300 text-brand-600">
                    </div>
                    <label for="terms" class="ml-2 text-sm text-gray-600">
                        I agree to the <a href="#" class="font-medium text-brand-600 hover:text-brand-500">Terms of Service</a> and <a href="#" class="font-medium text-brand-600 hover:text-brand-500">Privacy Policy</a>.
                    </label>
                </div>

                <!-- Submit Button -->
                <div>
                    <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-bold text-white bg-[#4a6741] hover:bg-[#3a5233] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-500 transition duration-150 ease-in-out">
                        REGISTER &rarr;
                    </button>
                </div>

                <div class="text-center mt-6">
                    <p class="text-sm text-gray-600">
                        Already have an account?
                        <a href="{{ route('login') }}" class="font-bold text-gray-900 hover:text-brand-600 transition-colors">Login</a>
                    </p>
                </div>
            </form>

            <div class="mt-16 text-center">
                <p class="text-xs text-gray-400 uppercase tracking-wider">
                    &copy; 2024 NOCTARINGEMS COSRENT. ALL RIGHTS RESERVED.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
