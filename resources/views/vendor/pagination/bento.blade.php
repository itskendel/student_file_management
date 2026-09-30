@if ($paginator->hasPages())
    <nav class="pagination" role="navigation" aria-label="{{ $ariaLabel ?? 'Pagination navigation' }}">
        @if ($paginator->onFirstPage())
            <span class="pagination-link" aria-disabled="true" aria-label="Previous page">
                <svg class="w-4 h-4 rtl:rotate-180" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd"
                        d="M12.79 5.23a.75.75 0 01-.02 1.06L8.83 10l3.94 3.71a.75.75 0 11-1.04 1.06l-4.5-4.24a.75.75 0 010-1.06l4.5-4.24a.75.75 0 011.06.02z"
                        clip-rule="evenodd" />
                </svg>
            </span>
        @else
            <a class="pagination-link" href="{{ $paginator->previousPageUrl() }}" rel="prev"
                aria-label="Previous page">
                <svg class="w-4 h-4 rtl:rotate-180" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd"
                        d="M12.79 5.23a.75.75 0 01-.02 1.06L8.83 10l3.94 3.71a.75.75 0 11-1.04 1.06l-4.5-4.24a.75.75 0 010-1.06l4.5-4.24a.75.75 0 011.06.02z"
                        clip-rule="evenodd" />
                </svg>
            </a>
        @endif

        @foreach ($elements as $element)
            @if (is_string($element))
                <span class="pagination-link" aria-disabled="true">{{ $element }}</span>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="pagination-link pagination-link-active" aria-current="page">
                            <span class="sr-only">Page</span>
                            {{ $page }}
                        </span>
                    @else
                        <a class="pagination-link" href="{{ $url }}" aria-label="Go to page {{ $page }}">
                            {{ $page }}
                        </a>
                    @endif
                @endforeach
            @endif
        @endforeach

        @if ($paginator->hasMorePages())
            <a class="pagination-link" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="Next page">
                <svg class="w-4 h-4 rtl:rotate-180" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd"
                        d="M7.21 14.77a.75.75 0 01.02-1.06L11.17 10 7.23 6.29a.75.75 0 111.04-1.06l4.5 4.24a.75.75 0 010 1.06l-4.5 4.24a.75.75 0 01-1.06-.02z"
                        clip-rule="evenodd" />
                </svg>
            </a>
        @else
            <span class="pagination-link" aria-disabled="true" aria-label="Next page">
                <svg class="w-4 h-4 rtl:rotate-180" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd"
                        d="M7.21 14.77a.75.75 0 01.02-1.06L11.17 10 7.23 6.29a.75.75 0 111.04-1.06l4.5 4.24a.75.75 0 010 1.06l-4.5 4.24a.75.75 0 01-1.06-.02z"
                        clip-rule="evenodd" />
                </svg>
            </span>
        @endif
    </nav>
@endif