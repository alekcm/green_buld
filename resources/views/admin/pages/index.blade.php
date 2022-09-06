@extends('layouts.admin')

@section('title')
    {{ trans('message.title', ['title' => 'Страницы']) }}
@endsection

@section('content')

    <h1>Страницы</h1>

    <div class="admin-actions">
        <form class="admin-actions__form" method="GET" action="" id="searchForm">
            <div class="search-input">
                <input type="text"
                       placeholder="Найти"
                       class="search-input__input js-apply-search-keypress"
                       name="q"
                       value="{{ Request::get('q', '') }}"
                >
                <button type="submit" class="search-input__btn">
                    <img src="{{ asset('img/search.svg') }}" alt="">
                </button>
            </div>
        </form>

        <a class="admin-actions__link" href="{{ route('admin.pages.create') }}">Создать</a>
    </div>

    <div class="admin-table">
        @component('components.data-table', [
            'items' => $items,
            'perPage' => $perPage,
            'columnFields' => [
                [
                    'attribute' => 'title',
                    'label' => 'Название',
                    'style' => 'width: 80%; min-width: 200px;',
                ],
                [
                    'attribute' => function(\App\Models\Page $row) { return $row->is_published ? 'Да' : 'Нет'; },
                    'label' => 'Опубликовано',
                    'style' => 'width: 20%; min-width: 100px;',
                ],
            ],
            'actions' => [
                'show' => function($item){ return route('web.pages.show', $item->path); },
                'edit' => function($item){ return route('admin.pages.edit', $item->slug); },
                'destroy' => function($item){ return route('admin.pages.destroy', $item->slug); },
            ]
        ])@endcomponent
    </div>

    <script>
        $(document).ready(function () {
            const searchForm = document.querySelector('#searchForm');

            document.querySelectorAll('.js-apply-search-keypress').forEach(x => {
                x.addEventListener('keypress', function (e) {
                    if (e.key === 'Enter') {
                        searchForm.submit();
                    }
                });
            });
        });
    </script>
@endsection
