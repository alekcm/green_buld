<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('img/favicon.svg') }}">
    <link rel="stylesheet" href="{{ asset('css/style.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/swiper.css') }}"/>
    <link rel="stylesheet" href="{{ asset('css/magnific-popup.css') }}"/>
    <link rel="stylesheet" href="{{ asset('css/additional-style.css') }}">

    <script src="{{ asset('js/vendor/jquery.min.js') }}"></script>
    <script src="{{ asset('js/vendor/magnific-popup/jquery.magnific-popup.min.js') }}"></script>

    <title>@yield('title')</title>
</head>

<body>

@include('layouts.partials.header')

<div class="container">

    @php
        $sibebarItemsRaw = \App\Models\Page::showMain()->available(Auth::user())->sortByOrder()->get()->filter(function(\App\Models\Page $item){
            return Auth::user()->role === \App\Enums\UserRoleEnum::ADMIN || !in_array(false, $item->ancestors()->get('is_published')->pluck('is_published')->toArray());
        })->map(function (\App\Models\Page $page){
            return [
                'name' => $page->title,
                'url' => route('web.pages.show', $page->path),
                'prefix' => 'pages/' . $page->path . '*',
            ];
        })->toArray();
    @endphp

    @if(Request::url() !== route('web.pages.index'))
        @include('layouts.partials.sidebar', [
            'sidebarItems' => array_merge(
                $sibebarItemsRaw, [
                    ['name' => 'Поиск информации по отбору', 'prefix' => 'search*', 'url' => route('web.search.index'),]
                ]
           ),]
        )
    @endif

    @yield('content')
</div>

@if(!(request()->url() === route('web.pages.index')))
    <div class="feedback-button js-open-modal">
        <img src="{{ asset('img/feedback_button.svg') }}" alt="Задать вопрос">
    </div>
@endif

<script src="{{ asset('js/modal.js') }}"></script>

@include('layouts.partials.feedback-modal')

</body>
</html>
