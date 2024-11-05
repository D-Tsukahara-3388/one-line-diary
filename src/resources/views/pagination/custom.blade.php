<div class="pagination">
    <ul class="pagination">
        @if ($paginator->onFirstPage())
            <li class="mr-1 disabled"><span>&laquo; </span></li>
        @else
            <li class="mr-1"><a href="{{ $paginator->previousPageUrl() }}" rel="prev">&laquo; </a></li>
        @endif

        @foreach ($elements as $element)
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="active"><span> [ {{ $page }} ] </span></li>
                    @else
                        <li><a href="{{ $url }}"> [ {{ $page }} ] </a></li>
                    @endif
                @endforeach
            @endif
        @endforeach

        @if ($paginator->hasMorePages())
            <li class="ml-1"><a href="{{ $paginator->nextPageUrl() }}" rel="next"> &raquo;</a></li>
        @else
            <li class="ml-1 disabled"><span> &raquo;</span></li>
        @endif
    </ul>
    <div class="ml-3">
    	{{ $paginator->total() }}件 ({{ ($paginator->currentPage() - 1) * $paginator->perPage() + 1 }} ～ {{ ($paginator->currentPage() - 1) * $paginator->perPage() + $paginator->count() }}件目表示中)
    </div>
</div>
