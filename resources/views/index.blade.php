@extends('layouts.home')


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
                    @auth
                        <a href="{{ route('dashboard') }}" class="hero__cta">Личный кабинет</a>
                    @else
                        <a href="{{ route('register') }}" class="hero__cta">Зарегистрироваться</a>
                    @endauth
                </div>
            </div>
            <div class="cloud"></div>
        </section>

        <section class="about-section">
            <div class="about-container">
                <div class="about-text">
                    <h2>Учим английский весело!</h2>
                    <p>
                        Наш сайт помогает детям легко и с интересом изучать английский язык.
                        Игры, красочные карточки делают обучение увлекательным!
                        Подходит для детей от 3 до 10 лет.
                    </p>
                    <a href="#" class="start-button">Начать учиться</a>
                </div>
                <div class="about-image">
                    <img src="/images/banner/i.webp" alt="Дети учат английский">
                </div>
            </div>
        </section>

        <!-- Секция с особенностями -->
        <section class="features-section">
            <div class="container">
                <h2 class="features-section__title">Что мы предлагаем?</h2>
                <div class="features-section__list">
                    <div class="features-section__item">
                        <h3 class="features-section__item-title"> Интерактивые задания</h3>
                        <p class="features-section__item-description">Игры, которые сделают обучение
                            веселым!</p>
                        <a class="features-section__link" href="{{ route('games') }}"></a>
                    </div>
                    <div class="features-section__item">
                        <h3 class="features-section__item-title">Прогресс</h3>
                        <p class="features-section__item-description">Следите за своим прогрессом и получайте баллы
                            за успешное
                            прохождение уроков.</p>
                    </div>
                </div>
            </div>
        </section>




    </main>
@endsection
