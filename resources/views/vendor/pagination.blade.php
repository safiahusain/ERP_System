@if ($paginator->hasPages())
    <nav>
        <ul class="pagination pagination">
            @if ($paginator->onFirstPage())
                <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                    <span class="page-link" aria-hidden="true"><i class="fa fa-angle-double-left" aria-hidden="true"></i></span>
                </li>
            @else
                <li class="page-item">
                    <a onclick="page_link_toggle(event,this);" class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')"><i class="fa fa-angle-double-left" aria-hidden="true"></i></a>
                </li>
            @endif
            @if($paginator->currentPage() > 2)
                <li class="page-item hidden-xs">
                    <a class="page-link" onclick="page_link_toggle(event,this);" href="{{ $paginator->url(1) }}">1</a>
                </li>
            @endif
            @if($paginator->currentPage() > 3)
                <li class="page-item">
                    <span class="page-link">...</span>
                </li>
            @endif
            @foreach(range(1, $paginator->lastPage()) as $i)
                @if($i >= $paginator->currentPage() - 1 && $i <= $paginator->currentPage() + 1)
                    @if ($i == $paginator->currentPage())
                        <li class="page-item active">
                            <span class="page-link">{{ $i }}</span>
                        </li>
                    @else
                        <li class="page-item">
                            <a class="page-link" onclick="page_link_toggle(event,this);" href="{{ $paginator->url($i) }}">{{ $i }}</a>
                        </li>
                    @endif
                @endif
            @endforeach
            @if($paginator->currentPage() < $paginator->lastPage() - 2)
                <li class="page-item">
                    <span class="page-link">...</span>
                </li>
            @endif
            @if($paginator->currentPage() < $paginator->lastPage() - 1)
                <li class="page-item hidden-xs">
                    <a class="page-link" onclick="page_link_toggle(event,this);" href="{{ $paginator->url($paginator->lastPage()) }}">{{ $paginator->lastPage() }}</a>
                </li>
            @endif
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a onclick="page_link_toggle(event,this);" class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')"><i class="fa fa-angle-double-right" aria-hidden="true"></i></a>
                </li>
            @else
                <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                    <span class="page-link" aria-hidden="true"><i class="fa fa-angle-double-right" aria-hidden="true"></i></span>
                </li>
            @endif
        </ul>
    </nav>
@endif
