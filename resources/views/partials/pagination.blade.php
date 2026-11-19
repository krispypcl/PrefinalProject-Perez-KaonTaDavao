{{-- Themed pagination, used with $eateries->links('partials.pagination').
     Laravel passes this view $paginator and $elements
     ($elements = groups of page numbers => URLs, with "..." strings for the gaps).
     The URLs already keep ?q=&district=&feature= because of withQueryString() in the controller. --}}
@if ($paginator->hasPages())
    <nav class="flex flex-col items-center justify-between gap-3 sm:flex-row" aria-label="Pagination">
        <p class="muted text-sm">
            Showing {{ $paginator->firstItem() }} to {{ $paginator->lastItem() }} of {{ $paginator->total() }} results
        </p>

        <div class="card flex items-center gap-1 p-1">
            {{-- Previous page --}}
            @if ($paginator->onFirstPage())
                <span class="page-link page-link-disabled" aria-disabled="true">
                    <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="page-link" rel="prev" aria-label="Previous page">
                    <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
                </a>
            @endif

            {{-- Page numbers --}}
            @foreach ($elements as $element)
                @if (is_string($element))
                    {{-- the "..." between far-apart pages --}}
                    <span class="page-link page-link-disabled">{{ $element }}</span>
                @else
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span class="page-link page-link-active" aria-current="page">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" class="page-link" aria-label="Page {{ $page }}">{{ $page }}</a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next page --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="page-link" rel="next" aria-label="Next page">
                    <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
                </a>
            @else
                <span class="page-link page-link-disabled" aria-disabled="true">
                    <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
                </span>
            @endif
        </div>
    </nav>
@endif
