@extends('layouts.user')

@section('title')
    {{ trans('message.title', ['title' => 'Начальная страница']) }}
@endsection

@section('content')
    <div class="content content--main">
        <h1>Интерактивный помощник</h1>
        <h2>Какую информацию Вы ищете?</h2>
        <div class="main-panels">
            @foreach($pages as $page)
                <a href="{{ route('web.pages.show', $page->path) }}" class="main-panels__item">
                    <p>{{ $page->title }}</p>
                    @if(!is_null($page->icon))
                        <img src="{{ asset(Storage::url($page->icon_path)) }}" alt="">
                    @endif
                </a>
            @endforeach

            <a href="{{ route('web.search.index') }}" class="main-panels__item">
                <p>Поиск информации по отбору</p>
                <img src="{{ asset('img/home/home_icon_7.svg') }}" alt="">
            </a>

            <a href="javascript:" class="main-panels__item js-open-modal">
                <p>Задать вопрос</p>
                <img src="{{ asset('img/home/home_icon_8.svg') }}" alt="">
            </a>
        </div>
    </div>
@endsection
