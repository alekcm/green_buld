<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('img/favicon.svg') }}">
    <link rel="stylesheet" href="{{ asset('css/style.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/additional-style.css') }}">

    <script src="{{ asset('js/vendor/jquery.min.js') }}"></script>

    <title>@yield('title')</title>
</head>
<body>

@yield('content')

<script src="{{ asset('js/modal.js') }}"></script>

@include('layouts.partials.forgot-password-modal')

</body>
</html>
