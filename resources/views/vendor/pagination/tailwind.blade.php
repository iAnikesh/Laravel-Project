@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination" class="mis-pagination flex items-center justify-between gap-4">
        <div class="hidden text-sm text-slate-600 sm:block">
            Showing
            <span class="font-medium">{{ $paginator->firstItem() }}</span>
            to
            <span class="font-medium">{{ $paginator->lastItem() }}</span>
            of
            <span class="font-medium">{{ $paginator->total() }}</span>
        </div>

        <div class="flex flex-1 justify-center gap-1 sm:justify-end">
            @if ($paginator->onFirstPage())
                <span class="cursor-not-allowed rounded-lg px-3 py-1.5 text-sm text-slate-300">Prev</span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="rounded-lg px-3 py-1.5 text-sm font-medium text-slate-600 hover:bg-slate-100">Prev</a>
            @endif

            @foreach ($elements as $element)
                @if (is_string($element))
                    <span class="px-2 py-1.5 text-sm text-slate-400">{{ $element }}</span>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span aria-current="page"><span class="inline-flex min-w-[2.25rem] items-center justify-center rounded-lg bg-emerald-600 px-3 py-1.5 text-sm font-semibold text-white">{{ $page }}</span></span>
                        @else
                            <a href="{{ $url }}" class="inline-flex min-w-[2.25rem] items-center justify-center rounded-lg px-3 py-1.5 text-sm font-medium text-slate-600 hover:bg-slate-100">{{ $page }}</a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="rounded-lg px-3 py-1.5 text-sm font-medium text-slate-600 hover:bg-slate-100">Next</a>
            @else
                <span class="cursor-not-allowed rounded-lg px-3 py-1.5 text-sm text-slate-300">Next</span>
            @endif
        </div>
    </nav>
@endif
