@extends('layouts.admin')

@php
    $nameLower = \App\Enums\ConfigEnum::CONFIGS[$attr];
@endphp

@section('title')
    {{ trans('message.title', ['title' => 'Редактировать ' . $nameLower]) }}
@endsection

@section('content')
    <div class="breadcrumbs">
        <a class="breadcrumbs__link" href="{{ route('admin.configs.index') }}">Настройки</a>
        <a class="breadcrumbs__link breadcrumbs__link--disabled">{{ $name }}</a>
        <span class="breadcrumbs__item">{{ 'Редактировать ' . $nameLower }}</span>
    </div>

    <h1 class="page-title page-title--edit-page">{{ 'Редактировать ' . $nameLower }}</h1>

    <form method="POST"
          action="{{ route('admin.configs.update', $attr) }}"
          class="form form--edit"
    >
        @method('PUT')
        @csrf

        <div class="form__group">
            @component('components.textarea', [
                'label' => $name,
                'type' => 'text',
                'name' => $attr,
                'value' => old($attr, $value),
                'placeholder' => 'Введите ' . $nameLower,
                'opts' => '',
            ])@endcomponent
        </div>

        <div class="form__actions">
            <button type="submit" id="submitButton" class="form__button form__button--medium">
                {{ 'Сохранить' }}
            </button>
            <a class="form__button form__button--medium form__button--transparent"
               href="{{ route('admin.configs.index') }}">Отменить</a>
        </div>
    </form>
@endsection
