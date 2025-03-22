@extends('layouts.home')

@section('title', 'Игры для детей')

@section('content')

    <main class="content">
        <!-- Герой-секция -->
        <section class="hero">
            <div class="container">
                <div class="hero-item">
                    <h1 class="hero__title">Добро пожаловать в мир английского языка!</h1>
                    <div class="hero__wrapper">
                        <p class="hero__subtitle">Привет, юный исследователь!
                            Чтобы начать своё приключение в мире английского языка, создай аккаунт и открой доступ к
                            интерактивным урокам и играм.
                        </p>
                    </div>
                    <a href="{{ route('register') }}" class="hero__cta">Зарегистрироваться</a>
                </div>
            </div>
        </section>

        <!-- Секция с особенностями -->
        <section class="features-section">
            <div class="container">
                <h2 class="features-section__title">Что мы предлагаем?</h2>
                <div class="features-section__list">
                    <div class="features-section__item">
                        <h3 class="features-section__item-title">Интерактивные уроки</h3>
                        <p class="features-section__item-description">Уроки с элементами игры и тестирования для детей,
                            которые
                            сделают обучение веселым!</p>
                        <a class="features-section__link" href="{{ route('games') }}"></a>
                    </div>
                    <div class="features-section__item">
                        <h3 class="features-section__item-title">Задания и викторины</h3>
                        <p class="features-section__item-description">Увлекательные задания и викторины, которые помогут
                            закрепить
                            материал и проверить свои знания.</p>
                    </div>
                    <div class="features-section__item">
                        <h3 class="features-section__item-title">Прогресс и достижения</h3>
                        <p class="features-section__item-description">Следите за своим прогрессом и получайте достижения
                            за успешное
                            прохождение уроков.</p>
                    </div>
                </div>
            </div>
        </section>


    </main>
@endsection
