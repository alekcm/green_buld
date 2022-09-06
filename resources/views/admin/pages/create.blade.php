@extends('layouts.admin')

@section('title')
    {{ trans('message.title', ['title' => empty($model) ? 'Создать страницу' : 'Редактировать страницу']) }}
@endsection

@section('content')
    <script src="{{ asset('js/vendor/ckeditor5/build/ckeditor.js') }}"></script>
    <script src="{{ asset('js/vendor/dropzone.min.js') }}"></script>

    <div class="breadcrumbs">
        <a class="breadcrumbs__link" href="{{ route('admin.pages.index') }}">Страницы</a>
        @if(empty($model))
            <span class="breadcrumbs__item">Создать страницу</span>
        @else
            <a class="breadcrumbs__link breadcrumbs__link--disabled">{{ $model->title }}</a>
            <span class="breadcrumbs__item">Редактировать страницу</span>
        @endif
    </div>

    <h1 class="page-title page-title--edit-page">{{ empty($model) ? 'Создать страницу' : 'Редактировать страницу' }}</h1>

    <form method="POST"
          action="{{ empty($model) ? route('admin.pages.store') : route('admin.pages.update', $model->slug) }}"
          enctype="multipart/form-data"
          class="form form--edit"
    >

        @method(empty($model) ? 'POST' : 'PUT')
        @csrf

        <input type="hidden" name="id" id="id" value="{{ empty($model) ? '' : $model->id }}">

        <div class="form__group">
            @component('components.input', [
                'label' => 'Название страницы',
                'type' => 'text',
                'name' => 'title',
                'value' => old('title', empty($model) ? '' : $model->title),
                'placeholder' => 'Введите название страницы',
                'opts' => 'required',
            ])@endcomponent
        </div>

        <div class="form__group">
            @component('components.select', [
                'label' => 'Родительская страница',
                'name' => 'parent_id',
                'value' => old('parent_id', empty($model) ? '' : $model->parent_id),
                'options' => \App\Models\Page::select(['id', 'title'])->pluck('title','id')->toArray(),
                'placeholder' => 'Выберите родительскую страницу',
                'opts' => '',
            ])@endcomponent
        </div>

        <div class="form__group">
            @component('components.input', [
                'label' => 'Порядок вывода в списке',
                'type' => 'number',
                'name' => 'order',
                'value' => old('order', empty($model) ? '' : $model->order),
                'placeholder' => 'Укажите порядок вывода в списке',
                'opts' => 'required min=0',
            ])@endcomponent
        </div>

        <div class="form__group">
            @component('components.checkbox', [
                'name' => 'show_main',
                'label' => 'Отображать на главной странице',
                'value' => old('show_main', empty($model) ? '' : $model->show_main),
                'opts' => '',
            ])@endcomponent
        </div>

        <div class="form__group">
            @component('components.checkbox', [
                'name' => 'is_published',
                'label' => 'Опубликована',
                'value' => old('is_published', empty($model) ? '' : $model->is_published),
                'opts' => '',
            ])@endcomponent
        </div>

        <div class="form__group" id="availableTitle">
            <div class="form__group-header">Кому доступна страница</div>
        </div>

        <div class="form__group form__group--inline" id="availableContainer">
            @foreach(\App\Enums\UserRoleEnum::AVAILABLE_ROLES as $roleKey => $roleLabel)
                @component('components.checkbox', [
                    'name' => 'available[' . $roleKey . ']',
                    'label' => $roleLabel,
                    'value' => old('available[][' . $roleKey . ']', empty($model) ? '' : in_array($roleKey, $model->available)),
                    'opts' => '',
                ])@endcomponent
            @endforeach
            @error('available')
            {{ $message }}
            @enderror
        </div>

        <div class="form__group">
            <div class="form__group-header">Иконка для главной страницы</div>
        </div>

        <div class="form__group">
            @component('components.dropzone',[
                'name' => 'icon',
                'value' => old('icon', empty($model) ? null : $model->icon_path),
                'pageId' => empty($model) ? '' : $model->id,
                'dropzoneConfig' => [
                    'label' => 'Перетащите файл сюда или нажмите на кнопку',
                    'description' => 'Поддерживаемые форматы: ' . strtoupper(config('app.page.icon.mimes')),
                    'uploadButton' => 'Загрузить файл',
                ],
            ])@endcomponent
        </div>

        <div class="form__group form__group--max-width">
            <div class="form__group-header">Контент</div>
            <div class="form__group-description">
                Заголовки первого и второго уровня определяют оглавление страницы
            </div>
        </div>

        <div class="form__group form__group--max-width">
            @component('components.ckeditor', [
                'name' => 'content',
                'value' => old('content', empty($model) ? '' : $model->content),
            ])@endcomponent
        </div>

        <div class="form__actions">
            <button type="submit" id="submitButton" class="form__button form__button--medium">
                {{ empty($model) ? 'Создать' : 'Сохранить' }}
            </button>
            <a class="form__button form__button--medium form__button--transparent"
               href="{{ route('admin.pages.index') }}">Отменить</a>
        </div>
    </form>

    <script>
        const availableTitle = document.getElementById('availableTitle');
        const availableContainer = document.getElementById('availableContainer');
        const isPublishedContainer = document.getElementById('isPublishedContainer');

        document.addEventListener("DOMContentLoaded", function () {

            document.getElementById('parent_id').addEventListener('change', function (e) {
                if (this.value) {
                    // hide
                    availableTitle.style.display = 'none';
                    availableContainer.style.display = 'none';

                } else {
                    // show
                    availableTitle.style.display = '';
                    availableContainer.style.display = '';
                }
            });

            // Trigger change event on load page
            document.getElementById('parent_id').dispatchEvent(new Event('change'));
        });
    </script>
@endsection
