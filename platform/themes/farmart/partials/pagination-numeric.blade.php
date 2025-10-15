@if ($paginator->hasPages())
    <div class="pagination-numeric-short">
        @if ($paginator->onFirstPage())
            <a href="#" class="disabled" aria-disabled="true" style="width:40px; height:40px; background-color:#7CAA53;">
                <span class="svg-icon">
                <i class="fa fa-chevron-left " style="font-size:16px; color:#000; margin-top:10px;"></i>
                </span>
            </a>
        @else
            <a href="{{ $paginator->previousPageUrl() }}"style="width:40px; height:40px; background-color:#7CAA53;">
                <span class="svg-icon">
                <i class="fa fa-chevron-left " style="font-size:16px; color:#000; margin-top:10px;"></i>
                </span>
            </a>
        @endif

        <form class="toolbar-pagination" action="{{ $paginator->path() }}" method="GET">
            @foreach (request()->input() as $key => $item)
                @if ($key != $paginator->getPageName() && is_string($item))
                    <input type="hidden" name="{{ $key }}" value="{{ $item }}">
                @endif
            @endforeach
            <input style="min-width:70px; font-size:15px;" class="catalog-page-number" type="number" name="{{ $paginator->getPageName() }}" value="{{ $paginator->currentPage() }}" min="1" max="{{ $paginator->lastPage() }}" step="1">
        </form><span style="font-size:16px;"> / {{ $paginator->lastPage() }}</span>

        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" style="width:40px; height:40px; background-color:#7CAA53;">
                <span class="svg-icon">
                <i class="fa fa-chevron-right " style="font-size:16px; color:#000; margin-top:10px;"></i>

                </span>
            </a>
        @else
            <a href="#" class="disabled" aria-disabled="true" style="width:40px; height:40px; background-color:#7CAA53;">
                <span class="svg-icon">
                <i class="fa fa-chevron-right " style="font-size:16px; color:#000; margin-top:10px;"></i>

                </span>
            </a>
        @endif
    </div>
@endif
