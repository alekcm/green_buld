@extends('layouts.admin')

@section('title')
    {{ trans('message.title', ['title' => empty($model) ? 'Создать пользователя' : 'Редактировать пользователя']) }}
@endsection

@section('content')
    <div class="breadcrumbs">
        <a class="breadcrumbs__link" href="{{ route('admin.users.index') }}">Пользователи</a>
        @if(empty($model))
            <span class="breadcrumbs__item">Создать пользователя</span>
        @else
            <a class="breadcrumbs__link breadcrumbs__link--disabled">{{ $model->name ?? $model->email }}</a>
            <span class="breadcrumbs__item">Редактировать пользователя</span>
        @endif
    </div>

    <h1 class="page-title page-title--edit-page">{{ empty($model) ? 'Создать пользователя' : 'Редактировать пользователя' }}</h1>

    <form method="POST"
          action="{{ empty($model) ? '' : route('admin.users.update', $model->id) }}"
          class="form form--edit"
    >

        @method(empty($model) ? 'POST' : 'PUT')
        @csrf

        <input type="hidden" name="id" id="id" value="{{ empty($model) ? '' : $model->id }}">

        <div class="form__group">
            @component('components.input', [
                'label' => 'ФИО',
                'type' => 'text',
                'name' => 'name',
                'value' => old('name', empty($model) ? '' : $model->name),
                'placeholder' => 'Введите ФИО',
                'opts' => '',
            ])@endcomponent
        </div>

        <div class="form__group">
            @component('components.input', [
                'label' => 'Email',
                'type' => 'email',
                'name' => 'email',
                'value' => old('email', empty($model) ? '' : $model->email),
                'placeholder' => 'Введите email',
                'opts' => 'required',
            ])@endcomponent
        </div>

        <div class="form__group">
            @component('components.input', [
                'label' => 'Новый пароль',
                'type' => 'password',
                'name' => 'password',
                'value' => '',
                'placeholder' => 'Введите новый пароль',
                'opts' => '',
            ])@endcomponent
            <div class="show-password js-show-password"></div>
        </div>

        <div class="form__group">
            @component('components.select', [
                'label' => 'Роль',
                'name' => 'role',
                'value' => old('role', empty($model) ? '' : $model->role),
                'options' => \App\Enums\UserRoleEnum::ROLES,
                'placeholder' => 'Выберите роль',
                'opts' => '',
            ])@endcomponent
        </div>

        <div class="form__actions">
            <button type="submit" id="submitButton" class="form__button form__button--medium">
                {{ empty($model) ? 'Создать' : 'Сохранить' }}
            </button>
            <a class="form__button form__button--medium form__button--transparent"
               href="{{ route('admin.users.index') }}">Отменить</a>
        </div>
    </form>

    <script src="{{ asset('js/show-password.js') }}"></script>
@endsection
