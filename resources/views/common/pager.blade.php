@if ($paginator->hasPages())
    <nav aria-label="navigation">
        <ul class="pagination justify-content-center mb-0 flex-wrap">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="page-item p-1 disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                    <span class="page-link border-0 rounded-circle fs-3 round-32 d-flex align-items-center justify-content-center" aria-hidden="true"><i class="fa-solid fa-chevron-left"></i></span>
                </li>
            @else
                <li class="page-item p-1">
                    <a class="page-link border-0 rounded-circle fs-3 round-32 d-flex align-items-center justify-content-center" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')"><i class="fa-solid fa-chevron-left"></i></a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="disabled page-item p-1" aria-disabled="true"><span class="page-link border-0 rounded-circle fs-3 round-32 d-flex align-items-center justify-content-center">{{ $element }}</span></li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="active page-item p-1" aria-current="page"><span class="page-link border-0 rounded-circle fs-3 round-32 d-flex align-items-center justify-content-center">{{ $page }}</span></li>
                        @else
                            <li class="page-item p-1"><a class="page-link border-0 rounded-circle fs-3 round-32 d-flex align-items-center justify-content-center" href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item p-1">
                    <a class="page-link border-0 rounded-circle fs-3 round-32 d-flex align-items-center justify-content-center" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')"><i class="fa-solid fa-chevron-right"></i></a>
                </li>
            @else
                <li class="disabled page-item p-1" aria-disabled="true" aria-label="@lang('pagination.next')">
                    <span class="page-link border-0 rounded-circle fs-3 round-32 d-flex align-items-center justify-content-center" aria-hidden="true"><i class="fa-solid fa-chevron-right"></i></span>
                </li>
            @endif
        </ul>
    </nav>
@endif
