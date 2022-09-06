<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('img/favicon.svg') }}">
    <link rel="stylesheet" href="{{ asset('css/style.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dropzone.css') }}">
    <link rel="stylesheet" href="{{ asset('css/additional-style.css') }}">

    <script src="{{ asset('js/vendor/jquery.min.js') }}"></script>

    <title>@yield('title')</title>
</head>

<body>

@include('layouts.partials.header')

<div class="container">
    @include('layouts.partials.sidebar', [
        'sidebarItems' => [
            ['name' => 'Страницы', 'prefix' => 'admin/pages*', 'url' => route('admin.pages.index'),],
            ['name' => 'Пользователи', 'prefix' => 'admin/users*', 'url' => route('admin.users.index'),],
            ['name' => 'Настройки', 'prefix' => 'admin/configs*', 'url' => route('admin.configs.index'),],
            ['name' => 'Информация по отбору', 'prefix' => 'admin/selection-info*', 'url' => route('admin.selection_info.create'),],
        ],
    ])
    <div class="content content--admin">
        @yield('content')
    </div>
</div>

<script src="{{ asset('js/vendor/notify.min.js') }}"></script>
<script src="{{ asset('js/notifications.js') }}"></script>
<script>
    function notify() {
        @if(session()->has('success'))
        notifyWithMessage('{{ session()->get('success') }}', 'info');
        @endif

        @if(session()->has('error'))
        notifyWithMessage('{{ session()->get('error') }}', 'error');
        @endif
    }

    document.addEventListener("DOMContentLoaded", notify);
</script>

</body>
</html>
