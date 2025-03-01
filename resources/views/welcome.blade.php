<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Главная страница</title>
    @vite('resources/js/app.js') <!-- Вставляем скомпилированные скрипты и стили через Vite -->
</head>

<body>
    @include('include.header')

    <main class="content">
        <!-- Герой-секция -->
        <section class="hero">
            <div class="container">
                <div class="hero-item">
                    <h1 class="hero__title">Добро пожаловать на сайт для изучения английского языка!</h1>
                    <p class="hero__subtitle">Лучшие ресурсы для обучения и игры для детей.</p>
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


    @include('include.footer')

    <script src="{{ mix('js/app.js') }}"></script>
</body>

</html>
