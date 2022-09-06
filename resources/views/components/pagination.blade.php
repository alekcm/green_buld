<div class="datatable-pagination">

    @if ($paginator->hasPages())
        <ul class="pagination">
            @if ($paginator->onFirstPage())
                <li class="pagination__button pagination__button--previous pagination__button--disabled">
                    <a href="#" tabindex="0" class="pagination__button-link">
                        Назад
                    </a>
                </li>
            @else
                <li class="pagination__button pagination__button--previous">
                    <a href="{{ $paginator->previousPageUrl() }}"
                       tabindex="0" class="pagination__button-link">
                        Назад
                    </a>
                </li>
            @endif

            @foreach ($elements as $element)
                @if (is_string($element))
                    <li class="pagination__button pagination__button--gap">
                        <a class="pagination__button-link">
                            {{ $element }}
                        </a>
                    </li>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="pagination__button pagination__button--active">
                                <a class="pagination__button-link">
                                    {{ $page }}
                                </a>
                            </li>
                        @else
                            <li class="pagination__button">
                                <a href="{{ $url }}"
                                   class="pagination__button-link">
                                    {{ $page }}
                                </a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            @if ($paginator->hasMorePages())
                <li class="pagination__button pagination__button--next">
                    <a href="{{ $paginator->nextPageUrl() }}"
                       class="pagination__button-link">
                        Вперёд
                    </a>
                </li>
            @else
                <li class="pagination__button pagination__button--next pagination__button--disabled">
                    <a href="#" class="pagination__button-link">
                        Вперёд
                    </a>
                </li>
            @endif
        </ul>
    @endif
</div>


