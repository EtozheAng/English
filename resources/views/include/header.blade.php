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
                <li><a href="{{ route('about') }}" class="menu-item">О нас</a></li>
                <li><a href="{{ route('alphabet') }}" class="menu-item">Алфавит</a></li>
                <li><a href="{{ route('dictionary') }}" class="menu-item">Словарь</a></li>
            </ul>
        </nav>
        <div class="header__auth">
            <a href="{{ route('login') }}" class="auth-button">Войти</a>
            <a href="{{ route('register') }}" class="auth-button">Зарегистрироваться</a>
        </div>
    </div>
</header>
