@extends('layouts.guest')

@section('title')
    {{ trans('message.title', ['title' => 'Вход']) }}
@endsection

@section('content')
    <div class="container container--login">
        <div class="login">
            <div class="login__logo">
                <img class="login__logo-img" src="{{ asset('img/logo.svg') }}" alt="">
            </div>

            <form class="form" action="{{ route('login.store') }}" method="POST">
                @csrf
                @method('POST')

                <div class="form__group">
                    @component('components.input', [
                        'label' => 'Почта',
                        'type' => 'email',
                        'name' => 'email',
                        'value' => old('email', ''),
                        'placeholder' => 'Введите почту',
                        'opts' => 'required',
                    ])@endcomponent
                </div>

                <div class="form__group">
                    <div class="form__group-label">
                        <label for="password">Пароль</label>
                        <a class="form__group-label-link js-open-forgot-password-modal" href="javascript:">Забыли пароль?</a>
                    </div>
                    @component('components.input', [
                        'type' => 'password',
                        'name' => 'password',
                        'value' => '',
                        'placeholder' => 'Введите пароль',
                        'opts' => 'required',
                    ])@endcomponent
                    <div class="show-password js-show-password"></div>
                </div>

                <div class="form__actions">
                    <button type="submit" class="form__button form__button--large">Войти</button>
                </div>
            </form>
        </div>
    </div>

    <script src="{{ asset('js/show-password.js') }}"></script>
@endsection
