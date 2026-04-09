@props([
    'paginator',
    'label' => 'data',
])

@php
    $paginator->appends(request()->except('page'));

    $current  = $paginator->currentPage();
    $last     = $paginator->lastPage();
    $window   = 2; // pages shown around current

    // Build page range with ellipsis markers (null = ellipsis)
    $pages = [];
    for ($p = 1; $p <= $last; $p++) {
        $nearCurrent = $p >= $current - $window && $p <= $current + $window;
        $isEdge      = $p === 1 || $p === $last;
        if ($nearCurrent || $isEdge) {
            $pages[] = $p;
        } elseif (end($pages) !== null) {
            $pages[] = null; // ellipsis marker
        }
    }
@endphp

<div class="mt-8 pt-6 border-t border-gray-50 flex flex-col sm:flex-row items-center justify-between gap-4">

    {{-- Info --}}
    <div class="text-sm text-gray-500">
        Menampilkan
        <span class="font-semibold text-gray-700">{{ $paginator->firstItem() ?? 0 }}–{{ $paginator->lastItem() ?? 0 }}</span>
        dari
        <span class="font-semibold text-gray-700">{{ $paginator->total() }}</span>
        {{ $label }}
    </div>

    {{-- Controls --}}
    @if($paginator->hasPages())
    <div class="flex items-center gap-1">

        {{-- Prev --}}
        @if($paginator->onFirstPage())
            <span class="px-3 py-2 text-sm text-gray-300 bg-gray-50 rounded-xl cursor-not-allowed select-none">&laquo;</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}"
               class="px-3 py-2 text-sm font-medium text-gray-600 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 transition-colors">
                &laquo;
            </a>
        @endif

        {{-- Page numbers --}}
        @foreach($pages as $page)
            @if($page === null)
                <span class="px-2 py-2 text-sm text-gray-400 select-none">…</span>
            @elseif($page === $current)
                <span class="px-3 py-2 text-sm font-bold text-white bg-brand-700 rounded-xl select-none">{{ $page }}</span>
            @else
                <a href="{{ $paginator->url($page) }}"
                   class="px-3 py-2 text-sm font-medium text-gray-600 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 transition-colors">
                    {{ $page }}
                </a>
            @endif
        @endforeach

        {{-- Next --}}
        @if($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}"
               class="px-3 py-2 text-sm font-medium text-gray-600 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 transition-colors">
                &raquo;
            </a>
        @else
            <span class="px-3 py-2 text-sm text-gray-300 bg-gray-50 rounded-xl cursor-not-allowed select-none">&raquo;</span>
        @endif

    </div>
    @endif

</div>
