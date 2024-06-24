<nav class="d-flex justify-items-center justify-content-between mb-5">
    <div class="d-flex justify-content-between flex-fill d-sm-none">
        <ul class="pagination">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled" aria-disabled="true">
                    <span class="page-link">@lang('pagination.previous')</span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev">@lang('pagination.previous')</a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($paginator as $element)
                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($paginator->currentPage() == $page)
                            <li class="page-item active" aria-current="page"><span class="page-link">{{ $page }}</span></li>
                        @else
                            <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next">@lang('pagination.next')</a>
                </li>
            @else
                <li class="page-item disabled" aria-disabled="true">
                    <span class="page-link">@lang('pagination.next')</span>
                </li>
            @endif
        </ul>
    </div>

    <div class="d-none flex-sm-fill d-sm-flex align-items-sm-center justify-content-sm-between">
        <div>
            <p class="small text-muted">
                {!! __('Showing') !!}
                <span class="fw-semibold">{{ $paginator->firstItem() }}</span>
                {!! __('to') !!}
                <span class="fw-semibold">{{ $paginator->lastItem() }}</span>
                {!! __('of') !!}
                <span class="fw-semibold">{{ $paginator->total() }}</span>
                {!! __('results') !!}
            </p>
        </div>

        <div>
            <ul class="pagination">
                {{-- Previous Page Link --}}
                @if ($paginator->onFirstPage())
                    <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                        <span class="page-link" aria-hidden="true">&lsaquo;</span>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')">&lsaquo;</a>
                    </li>
                @endif

                {{-- Pagination Elements --}}
                @php
                    // Number of pagination links before showing the last page number
                    $numPaginationLinks = 5;

                    // Calculate the starting page number
                    $startPage = max(1, $paginator->currentPage() - floor($numPaginationLinks / 2));

                    // Calculate the ending page number
                    $endPage = min($paginator->lastPage(), $startPage + $numPaginationLinks - 1);
                @endphp

                @if ($startPage > 1)
                    <li class="page-item disabled" aria-disabled="true"><span class="page-link">...</span></li>
                @endif

                {{-- Display the pagination links within the range --}}
                @for ($i = $startPage; $i <= $endPage; $i++)
                    <li class="page-item {{ ($paginator->currentPage() == $i) ? 'active' : '' }}"><a class="page-link" href="{{ $paginator->url($i) }}">{{ $i }}</a></li>
                @endfor

                {{-- Show the last page number --}}
                @if ($endPage < $paginator->lastPage())
                    <li class="page-item disabled" aria-disabled="true"><span class="page-link">...</span></li>
                    <li class="page-item"><a class="page-link" href="{{ $paginator->url($paginator->lastPage()) }}">{{ $paginator->lastPage() }}</a></li>
                @endif

                {{-- Next Page Link --}}
                @if ($paginator->hasMorePages())
                    <li class="page-item">
                        <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')">&rsaquo;</a>
                    </li>
                @else
                    <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                        <span class="page-link" aria-hidden="true">&rsaquo;</span>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>