@if ($paginator->hasPages())
    <nav aria-label="Pagination" class="d-flex justify-content-center">
        <ul class="pagination pagination-sm mb-0 gap-2">

            {{-- Previous --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled" aria-disabled="true">
                    <span class="page-link rounded-pill border-0 shadow-sm px-3">
                        <i class="ri-arrow-left-s-line"></i>
                    </span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link rounded-pill border-0 shadow-sm px-3"
                       href="{{ $paginator->previousPageUrl() }}"
                       rel="prev"
                       aria-label="Previous">
                        <i class="ri-arrow-left-s-line"></i>
                    </a>
                </li>
            @endif

            {{-- Elements --}}
            @foreach ($elements as $element)
                {{-- ... Separator --}}
                @if (is_string($element))
                    <li class="page-item disabled" aria-disabled="true">
                        <span class="page-link rounded-pill border-0 bg-transparent px-2">{{ $element }}</span>
                    </li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active" aria-current="page">
                                <span class="page-link rounded-pill border-0 shadow-sm px-3">
                                    {{ $page }}
                                </span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link rounded-pill border-0 shadow-sm px-3"
                                   href="{{ $url }}">
                                    {{ $page }}
                                </a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link rounded-pill border-0 shadow-sm px-3"
                       href="{{ $paginator->nextPageUrl() }}"
                       rel="next"
                       aria-label="Next">
                        <i class="ri-arrow-right-s-line"></i>
                    </a>
                </li>
            @else
                <li class="page-item disabled" aria-disabled="true">
                    <span class="page-link rounded-pill border-0 shadow-sm px-3">
                        <i class="ri-arrow-right-s-line"></i>
                    </span>
                </li>
            @endif

        </ul>
    </nav>
@endif
