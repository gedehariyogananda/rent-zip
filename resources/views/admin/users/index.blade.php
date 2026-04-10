@extends('layouts.admin')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-brand-800 mb-2">Manajemen Pengguna</h1>
    <p class="text-gray-500">Kelola data member dan administrator sistem.</p>
</div>

{{-- Tab + Tambah --}}
<div class="flex items-center justify-between mb-6">
    <div class="flex gap-2">
        <a href="{{ route('admin.users.index', ['role' => 'member']) }}"
           class="px-5 py-2 rounded-xl text-sm font-semibold transition-colors
                  {{ $roleName === 'member' ? 'bg-brand-700 text-white shadow-sm' : 'bg-white text-gray-600 border border-gray-200 hover:bg-gray-50' }}">
            Member
        </a>
        <a href="{{ route('admin.users.index', ['role' => 'admin']) }}"
           class="px-5 py-2 rounded-xl text-sm font-semibold transition-colors
                  {{ $roleName === 'admin' ? 'bg-brand-700 text-white shadow-sm' : 'bg-white text-gray-600 border border-gray-200 hover:bg-gray-50' }}">
            Admin
        </a>
    </div>
    <a href="{{ route('admin.users.create') }}"
       class="flex items-center gap-2 px-5 py-2.5 bg-brand-700 hover:bg-brand-800 text-white rounded-xl text-sm font-bold transition-colors shadow-sm">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
        </svg>
        Tambah {{ ucfirst($roleName) }}
    </a>
</div>

<div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="p-6 border-b border-gray-50 flex items-center justify-between">
        <h2 class="text-xl font-bold text-gray-800">
            Daftar {{ ucfirst($roleName) }}
        </h2>
        <span class="text-xs font-bold tracking-wider uppercase px-3 py-1 rounded-full bg-brand-50 text-brand-700">
            {{ $users->count() }} total
        </span>
    </div>

    <div class="p-6">
        {{-- Table Header --}}
        <div class="grid grid-cols-12 gap-4 pb-4 border-b border-gray-50 text-xs font-bold text-gray-400 uppercase tracking-wider px-4">
            <div class="col-span-1">#</div>
            <div class="col-span-3">USERNAME</div>
            <div class="col-span-4">EMAIL</div>
            <div class="col-span-2">PHONE</div>
            <div class="col-span-2 text-right">AKSI</div>
        </div>

        {{-- Table Body --}}
        <div class="space-y-3 mt-4">
            @forelse($users as $user)
            <div class="grid grid-cols-12 gap-4 items-center p-4 bg-gray-50/50 rounded-xl hover:bg-gray-50 transition-colors">
                <div class="col-span-1 text-sm font-bold text-gray-400">{{ $loop->iteration }}</div>
                <div class="col-span-3 flex items-center gap-3">
                    @if($user->avatar_url)
                        <img src="{{ Storage::url($user->avatar_url) }}" alt="Avatar" class="w-8 h-8 rounded-lg object-cover flex-shrink-0">
                    @else
                        <div class="w-8 h-8 rounded-lg flex items-center justify-center flex-shrink-0 bg-brand-100 text-brand-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    @endif
                    <span class="text-sm font-semibold text-gray-800">{{ $user->username }}</span>
                </div>
                <div class="col-span-4 text-sm text-gray-600">
                    {{ $user->email }}
                </div>
                <div class="col-span-2 text-sm text-gray-600">
                    {{ $user->phone ?: '-' }}
                </div>
                <div class="col-span-2 flex justify-end relative group">
                    <button class="text-gray-400 hover:text-gray-600 p-1 focus:outline-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z" />
                        </svg>
                    </button>
                    <div class="absolute right-0 top-8 w-32 bg-white rounded-lg shadow-lg border border-gray-100 py-1 z-10 hidden group-hover:block group-focus-within:block">
                        <a href="{{ route('admin.users.show', $user->id) }}"
                           class="block px-4 py-2 text-sm text-brand-700 hover:bg-brand-50">Detail</a>
                        <a href="{{ route('admin.users.edit', $user->id) }}"
                           class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Edit</a>
                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    onclick="return confirm('Hapus user \'{{ $user->username }}\'?')"
                                    class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @empty
            <div class="py-16 text-center">
                <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-gray-100 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
                <p class="text-gray-500 text-sm font-medium">Belum ada pengguna {{ $roleName }}.</p>
                <a href="{{ route('admin.users.create') }}"
                   class="mt-3 inline-flex items-center text-sm font-semibold text-brand-600 hover:text-brand-800">
                    + Tambah sekarang
                </a>
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
