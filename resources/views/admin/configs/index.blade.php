@extends('layouts.admin')

@section('title')
    {{ trans('message.title', ['title' => 'Настройки']) }}
@endsection

@section('content')

    <h1>Настройки</h1>

    <div class="admin-table">
        @component('components.data-table', [
            'items' => $items,

            'columnFields' => [
                [
                    'attribute' => 'name',
                    'label' => 'Настройка',
                    'style' => 'width: 50%; min-width: 200px;',
                ],
                [
                    'attribute' => 'value',
                    'label' => 'Значение',
                    'style' => 'width: 50%; min-width: 200px;',
                ],
            ],
            'actions' => [
                'edit' => function($item){ return route('admin.configs.edit', $item['attr']); }
            ]
        ])@endcomponent
    </div>
@endsection
