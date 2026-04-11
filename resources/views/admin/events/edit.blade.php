@extends('layouts.admin')

@section('title', 'Edit Event')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-900">Edit Event</h1>
        <a href="{{ route('admin.events.index') }}" class="text-sm font-medium text-gray-500 hover:text-gray-700">
            Back to Events
        </a>
    </div>

    <form action="{{ route('admin.events.update', $event->id) }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
        @csrf
        @method('PUT')
        <div class="p-8 space-y-8">
            <h2 class="text-xl font-bold text-[#1a331a]">Event Details</h2>

            <!-- Event Name -->
            <div>
                <label for="name" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Event Name</label>
                <input type="text" name="name" id="name" class="w-full bg-[#f8faf8] border-0 text-gray-900 rounded-xl focus:ring-2 focus:ring-[#2b4c2b] block p-4 transition-colors" placeholder="e.g. Neo-Tokyo Summer Festival" value="{{ old('name', $event->name) }}" required>
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Event Date -->
                <div>
                    <label for="date" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Event Date</label>
                    <input type="date" name="date" id="date" class="w-full bg-[#f8faf8] border-0 text-gray-900 rounded-xl focus:ring-2 focus:ring-[#2b4c2b] block p-4 transition-colors" value="{{ old('date', $event->date ? $event->date->format('Y-m-d') : '') }}" required>
                    @error('date')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Location -->
                <div>
                    <label for="location" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Location</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <input type="text" name="location" id="location" class="w-full bg-[#f8faf8] border-0 text-gray-900 rounded-xl focus:ring-2 focus:ring-[#2b4c2b] block pl-11 p-4 transition-colors" placeholder="Convention Center, Hall A" value="{{ old('location', $event->location) }}" required>
                    </div>
                    @error('location')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Upload Event Banner -->
            <div>
                <label for="image" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Upload Event Banner</label>
                <div class="mt-1 flex justify-center px-6 pt-10 pb-10 border-2 border-gray-200 border-dashed rounded-3xl bg-[#f8faf8] hover:bg-gray-100 transition-colors relative cursor-pointer group" onclick="document.getElementById('image').click()">
                    <div class="space-y-2 text-center">
                        <div class="mx-auto h-16 w-16 bg-white rounded-full flex items-center justify-center shadow-sm mb-4 group-hover:scale-105 transition-transform">
                            <svg class="h-8 w-8 text-[#2b4c2b]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div class="flex text-base text-gray-800 justify-center font-bold">
                            <span>Drop your new image here (optional)</span>
                            <input id="image" name="image" type="file" class="sr-only" accept="image/*">
                        </div>
                        <p class="text-sm text-gray-400">PNG, JPG or WebP up to 10MB</p>
                        <div class="pt-4">
                            <button type="button" class="px-6 py-2 bg-white border border-gray-200 shadow-sm text-sm font-bold rounded-xl text-[#2b4c2b] hover:bg-gray-50 focus:outline-none">
                                Browse Files
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Preview Area -->
                <div id="image-preview" class="mt-4 hidden">
                    <p class="text-sm font-medium text-gray-700 mb-2">New Image Preview:</p>
                    <img id="preview-img" src="#" alt="Preview" class="max-h-64 rounded-2xl object-cover border border-gray-200 shadow-sm w-full">
                </div>

                <!-- Current Image Area -->
                @if($event->image_url)
                    <div id="current-image" class="mt-4">
                        <p class="text-sm font-medium text-gray-700 mb-2">Current Banner:</p>
                        <img src="{{ Storage::url($event->image_url) }}" alt="{{ $event->name }}" class="max-h-64 rounded-2xl object-cover border border-gray-200 shadow-sm w-full">
                    </div>
                @endif

                @error('image')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="px-8 py-6 bg-[#fafafa] flex items-center justify-end gap-6 border-t border-gray-100">
            <a href="{{ route('admin.events.index') }}" class="text-sm font-bold text-gray-800 hover:text-gray-600 transition-colors">
                Cancel
            </a>
            <button type="submit" class="px-8 py-3 bg-[#2b4c2b] hover:bg-[#1e361e] text-white rounded-xl text-sm font-bold transition-colors shadow-sm inline-flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                </svg>
                Update Event
            </button>
        </div>
    </form>
</div>

<script>
    document.getElementById('image').addEventListener('change', function(e) {
        const preview = document.getElementById('image-preview');
        const previewImg = document.getElementById('preview-img');
        const currentImage = document.getElementById('current-image');
        const file = e.target.files[0];

        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImg.src = e.target.result;
                preview.classList.remove('hidden');
                if (currentImage) {
                    currentImage.classList.add('hidden');
                }
            }
            reader.readAsDataURL(file);
        } else {
            preview.classList.add('hidden');
            if (currentImage) {
                currentImage.classList.remove('hidden');
            }
        }
    });
</script>
@endsection
