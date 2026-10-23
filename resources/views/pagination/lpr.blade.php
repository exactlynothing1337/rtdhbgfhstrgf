@if ($paginator->hasPages())
    <nav class="pager" role="navigation" aria-label="Страницы">
        @if ($paginator->onFirstPage())
            <span class="pager__item is-disabled" aria-hidden="true">←</span>
        @else
            <a class="pager__item" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="Предыдущая">←</a>
        @endif

        @foreach ($elements as $element)
            @if (is_string($element))
                <span class="pager__item is-disabled">{{ $element }}</span>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="pager__item is-current" aria-current="page">{{ $page }}</span>
                    @else
                        <a class="pager__item" href="{{ $url }}">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        @if ($paginator->hasMorePages())
            <a class="pager__item" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="Следующая">→</a>
        @else
            <span class="pager__item is-disabled" aria-hidden="true">→</span>
        @endif
    </nav>
@endif
