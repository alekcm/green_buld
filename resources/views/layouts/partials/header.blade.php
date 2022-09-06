<header class="header">

    <a href="{{ route('web.pages.index') }}" class="header-logo">
        <img src="{{ asset('img/logo.svg') }}" alt="">
    </a>

    <div class="header-user">

        <div class="header-user__info">
            <div class="header-user__name">
                {{ Auth::user()->name ?? Auth::user()->email }}
            </div>
            <div class="header-user__role">
                {{ \App\Enums\UserRoleEnum::find(Auth::user()->role)->getName() }}
            </div>
        </div>

        <div class="header-user__actions">
            @if(Auth::user()->role === \App\Enums\UserRoleEnum::ADMIN)
                @if(!Route::is('admin*'))
                    <a class="header-user__action-btn"
                       href="{{ route('admin.pages.index') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="23" height="17" viewBox="0 0 23 17" fill="none">
                            <path
                                d="M1 1V0H0V1H1ZM1 16H0V17H1V16ZM22 1H23V0H22V1ZM22 16V17H23V16H22ZM5 13C5.55228 13 6 12.5523 6 12C6 11.4477 5.55228 11 5 11V13ZM5 9C5.55228 9 6 8.55228 6 8C6 7.44772 5.55228 7 5 7V9ZM5 5C5.55228 5 6 4.55228 6 4C6 3.44772 5.55228 3 5 3V5ZM0 1V4H2V1H0ZM0 4V8H2V4H0ZM0 8V12H2V8H0ZM0 12V16H2V12H0ZM8 1V16H10V1H8ZM21 1V16H23V1H21ZM1 2H9V0H1V2ZM9 2H22V0H9V2ZM1 17H9V15H1V17ZM9 17H22V15H9V17ZM1 13H5V11H1V13ZM1 9H5V7H1V9ZM1 5H5V3H1V5Z"
                                fill="#002033"/>
                        </svg>
                    </a>
                @endif
            @endif

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                @method('POST')
                <button type="submit" class="header-user__action-btn" title="Выйти">
                    <svg width="19" height="16" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M16 20L3 20L3 4L16 4V9L14 9V6H5V18L14 18V15H16V20Z"/>
                        <path d="M18 16L22 12L18 8V11L9 11L9 13L18 13V16Z"/>
                    </svg>
                </button>
            </form>
        </div>
    </div>
</header>
