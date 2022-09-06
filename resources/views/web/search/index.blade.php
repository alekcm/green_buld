@extends('layouts.user')

@section('title')
    {{ trans('message.title', ['title' => 'Поиск информации по отбору']) }}
@endsection

@section('content')
    <div class="content">
        @component('components.breadcrumbs', ['breadcrumbs' => [
            ['title' => 'Поиск информации по отбору', 'path' => '']
        ]])@endcomponent

        <h1>Поиск информации по отбору</h1>
        <div class="search">
            <div class="search__inner">
                <form class="search__form" method="GET" action="#">

                    <h2>Укажите реестровый номер процедуры</h2>

                    <input class="search__input js-use-pattern"
                           type="text"
                           name="procedure_number"
                           id="procedure_number"
                           pattern="^[\d-]+"
                           placeholder="__-_______-___-____"
                           value="{{ request()->get('procedure_number') }}"
                    >

                    <button type="submit" class="search__form-btn">Найти</button>
                </form>
            </div>
        </div>

        @isset($result)
            @if(count($result))
                <div class="search-result-table">
                    @component('components.data-table', [
                        'items' => $result,
                        'columnFields' => [
                            [
                                'attribute' => 'procedure_number',
                                'label' => 'Реестровый номер процедуры',
                                'style' => 'width: 15%; min-width: 150px;',
                            ],
                            [
                                'attribute' => 'lot_number',
                                'label' => 'Реестровый номер лота',
                                'style' => 'width: 15%; min-width: 150px;',
                            ],
                            [
                                'attribute' => 'lot_subject',
                                'label' => 'Предмет лота',
                                'style' => 'width: 15%; min-width: 150px;',
                            ],
                            [
                                'attribute' => 'status_name',
                                'label' => 'Статус процедуры',
                                'style' => 'width: 15%; min-width: 130px;',
                            ],
                            [
                                'attribute' => 'step_name',
                                'label' => 'Шаг процедуры',
                                'style' => 'width: 15%; min-width: 130px;',
                            ],
                            [
                                'attribute' => 'formatted_started_at',
                                'label' => 'Дата начала подачи заявок',
                                'style' => 'width: 10%; min-width: 100px;',
                            ],
                            [
                                'attribute' => 'formatted_ended_at',
                                'label' => 'Дата окончания подачи заявок',
                                'style' => 'width: 10%; min-width: 100px;',
                            ],
                            [
                                'attribute' => 'proposals_number',
                                'label' => 'Заявки',
                                'style' => 'width: 5%; min-width: 50px;',
                            ],
                        ],
                    ])@endcomponent
                </div>
            @else
                <div class="search-result-empty">
                    <div class="search-result-empty__inner">
                        <h2>Информация по указанному номеру не найдена.</h2>
                        <p>Обратитесь с вашим вопросом, написав на почту
                            <a href="mailto:uzuir_gpn-s@gazprom-neft.ru">uzuir_gpn-s@gazprom-neft.ru</a>
                        </p>
                    </div>
                </div>
            @endif
        @endisset
    </div>
    <script src="{{ asset('js/vendor/inputmask.min.js') }}"></script>
    <script>
        document.querySelectorAll('.js-use-pattern').forEach(x => {
            let inputMask = new Inputmask('99-9999999-999-9999');
            inputMask.mask(x)
        });
    </script>
@endsection
