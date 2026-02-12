@if ($paginator->hasPages())
<div class="blog__pagination">
    {{-- Previous Page Link --}}
    @if ($paginator->onFirstPage())
        <a href="#" class="disabled"><i class="fa fa-long-arrow-left"></i> Prev</a>
    @else
        <a href="{{ $paginator->previousPageUrl() }}"><i class="fa fa-long-arrow-left"></i> Prev</a>
    @endif

    {{-- Pagination Elements --}}
    @foreach ($elements as $element)
        {{-- "Three Dots" Separator --}}
        @if (is_string($element))
            <a href="#" class="disabled">{{ $element }}</a>
        @endif

        {{-- Array Of Links --}}
        @if (is_array($element))
            @foreach ($element as $page => $url)
                @if ($page == $paginator->currentPage())
                    <a href="#" class="active">{{ $page }}</a>
                @else
                    <a href="{{ $url }}">{{ $page }}</a>
                @endif
            @endforeach
        @endif
    @endforeach

    {{-- Next Page Link --}}
    @if ($paginator->hasMorePages())
        <a href="{{ $paginator->nextPageUrl() }}">Next <i class="fa fa-long-arrow-right"></i></a>
    @else
        <a href="#" class="disabled">Next <i class="fa fa-long-arrow-right"></i></a>
    @endif
</div>
@endif
