@extends('layouts.admin')

@section('title')
    {{ trans('message.title', ['title' => 'Пользователи']) }}
@endsection

@section('content')

    <h1>Пользователи</h1>

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
    </div>

    <div class="admin-table">
        @component('components.data-table', [
            'items' => $items,
            'perPage' => $perPage,
            'columnFields' => [
                [
                    'attribute' => 'email',
                    'label' => 'Email',
                    'style' => 'width: 75%; min-width: 200px;',
                ],
                [
                    'attribute' => 'name',
                    'label' => 'ФИО',
                    'style' => 'width: 75%; min-width: 200px;',
                ],
                [
                    'attribute' => function(\App\Models\User $item){ return \App\Enums\UserRoleEnum::find($item->role)->getName();},
                    'label' => 'Роль',
                    'style' => 'width: 75%; min-width: 200px;',
                ],
            ],
            'actions' => [
                'edit' => function(\App\Models\User $item){ return route('admin.users.edit', $item->id); },
                'block' => [
                    'url' => function(\App\Models\User $item){ return route('admin.users.block', $item->id); },
                    'is_blocked' => function(\App\Models\User $item) { return $item->is_blocked; },
                ],
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
