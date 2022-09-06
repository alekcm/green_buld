@extends('layouts.admin')

@section('title')
    {{ trans('message.title', ['title' => 'Информация по отбору']) }}
@endsection

@section('content')
    <script src="{{ asset('js/vendor/dropzone.min.js') }}"></script>

    <h1 class="page-title">{{ 'Информация по отбору' }}</h1>

    <form method="POST"
          action="{{ route('admin.selection_info.store') }}"
          class="form form--edit"
    >
        @method('POST')
        @csrf

        <div class="form__group">
            Дата последней загрузки: {{ \App\Models\SelectionInfo::first()?->formatted_created_at ?? '' }}
        </div>

        <div class="form__group">
            @component('components.dropzone-file',[
                'name' => 'file',
                'value' => old('file', ''),
                'pageId' => '',
                'dropzoneConfig' => [
                    'label' => 'Перетащите файл сюда или нажмите на кнопку',
                    'description' => 'Поддерживаемые форматы: ' . strtoupper(config('app.selection_info.mimes')),
                    'uploadButton' => 'Загрузить файл',
                ],
            ])@endcomponent
        </div>

        <div class="form__actions">
            <button type="submit" id="submitButton" class="form__button form__button--medium">
                {{ 'Загрузить' }}
            </button>
            <a class="form__button form__button--medium form__button--transparent"
               href="{{ request()->url() }}">{{ 'Отменить' }}</a>
        </div>
    </form>
@endsection
