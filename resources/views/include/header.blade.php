<header class="header">
    <div class="container header__container">
        <div class="header__logo">
            <a href="{{ url('/') }}" class="logo">
                <x-application-logo />
            </a>
        </div>
        <nav class="header__nav">
            <ul class="header__menu">
                <li><a href="{{ route('home') }}" class="menu-item">Главная</a></li>
                <li><a href="{{ route('games') }}" class="menu-item">Игры</a></li>
                <li><a href="{{ route('alphabet') }}" class="menu-item">Алфавит</a></li>
                <li><a href="{{ route('dictionary') }}" class="menu-item">Словарь</a></li>
            </ul>
        </nav>
        <div class="header__auth">
            @auth
                <a href="{{ route('dashboard') }}" class="header__user-nickname">{{ Auth::user()->name }}</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="auth-button">Выйти</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="auth-button">Войти</a>
                <a href="{{ route('register') }}" class="auth-button">Зарегистрироваться</a>
            @endauth
        </div>
    </div>
</header>
