<!-- resources/views/games/index.blade.php -->
@extends('layouts.home')

@section('title', 'Игры для детей')

@section('content')
    <div class="container py-8">
        <h1 class="text-4xl font-bold mb-6">Игры для детей</h1>
        <div class="features">
            <!-- Первая игра -->
            <div class="feature">
                <h3 class="feature__title">Игра 1</h3>
                <p class="feature__description">
                    Уроки с элементами игры и тестирования для детей, которые сделают обучение веселым!
                </p>
                <a href="{{ route('games.image-card-section') }}" class="btn btn-primary">Играть</a>
            </div>

            <!-- Вторая игра -->
            <div class="feature">
                <h3 class="feature__title">Игра 2</h3>
                <p class="feature__description">
                    Развивающие игры для тренировки математических навыков с увлекательными задачами.
                </p>
                <a href="{{ route('games.connect-words') }}" class="btn btn-primary">Играть</a>
            </div>

            <!-- Третья игра -->
            <div class="feature">
                <h3 class="feature__title">Игра 3</h3>
                <p class="feature__description">
                    Игры для тренировки логического мышления и решения задач с элементами стратегии.
                </p>
                <a href="{{ route('games.create-words-section') }}" class="btn btn-primary">Играть</a>
            </div>

            <!-- Четвертая игра -->
            <div class="feature">
                <h3 class="feature__title">Игра 4</h3>
                <p class="feature__description">
                    Игры для тренировки логического мышления и решения задач с элементами стратегии.
                </p>
                <a href="{{ route('games.missing-letter-game-section') }}" class="btn btn-primary">Играть</a>
            </div>

            <!-- Дополнительные игры можно добавлять по аналогии -->
        </div>
    </div>
@endsection
