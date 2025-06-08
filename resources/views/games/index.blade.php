<!-- resources/views/games/index.blade.php -->
@extends('layouts.home')

@section('title', 'Игры для детей')

@section('content')
    <div class="container py-8">
        <h1 class="text-4xl font-bold mb-6">Игры для детей</h1>
        <div class="features">
            <!-- Первая игра -->
            <div class="feature">
                <h3 class="feature__title">Угадай слово по картинке</h3>
                <p class="feature__description">
                    Развивающая игра для детей, где нужно угадать слово, соответствующее изображению.
                </p>
                <a href="{{ route('games.image-card-section') }}" class="btn btn-primary">Играть</a>
            </div>
            <!-- Третья игра -->
            <div class="feature">
                <h3 class="feature__title">Собери слово из букв</h3>
                <p class="feature__description">
                    Составляйте слова из предложенных букв - отличная тренировка правописания и словарного запаса.
                </p>
                <a href="{{ route('games.create-words-section') }}" class="btn btn-primary">Играть</a>
            </div>

            <!-- Четвертая игра -->
            <div class="feature">
                <h3 class="feature__title">Встать пропущенную букву</h3>
                <p class="feature__description">
                    Встать недостающую букву в слове - игра, развивающая внимательность и знание орфографии.
                </p>
                <a href="{{ route('games.missing-letter-game-section') }}" class="btn btn-primary">Играть</a>
            </div>

            <!-- Пятая игра -->
            <div class="feature">
                <h3 class="feature__title">Угадай слово на слух</h3>
                <p class="feature__description">
                    Тренируем восприятие на слух - угадайте слово по его звучанию и улучшайте свои навыки аудирования.
                </p>
                <a href="{{ route('audio-quiz.sections') }}" class="btn btn-primary">Играть</a>
            </div>

            <!-- Дополнительные игры можно добавлять по аналогии -->
        </div>
    </div>
@endsection
