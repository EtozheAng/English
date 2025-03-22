<!-- resources/views/games/index.blade.php -->
@extends('layouts.home')

@section('title', 'Игры для детей')

@section('content')
    <style>
        .game-container {
            text-align: center;
            margin-top: 50px;
            margin-bottom: 30px;
        }

        .game-image {
            width: 300px;
            height: auto;
            margin-bottom: 20px;
        }

        .word-options {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-bottom: 20px;
        }

        .word-options button {
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
        }

        .score {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .lavel-image {
            min-height: 300px
        }
    </style>

    <div class="game-container">
        <h1>Игра: Выберите правильное слово</h1>
        <div class="score">Очки: <span id="score">0</span></div>
        <div class="level-container" id="level-container">
            <!-- Уровни будут загружаться здесь -->
        </div>
        <p id="result"></p>
    </div>

    <script>
        // Данные уровней
        const levels = @json($levels);
        let currentLevel = 0;
        let score = 0;

        // Функция для загрузки уровня
        function loadLevel() {
            if (currentLevel >= levels.length) {
                document.getElementById('level-container').innerHTML = '<h2>Игра завершена! 🎉</h2>';
                return;
            }

            const level = levels[currentLevel];
            const words = level.words.map(word => `
                <button onclick="checkAnswer('${word}', '${level.correct_word}')">${word}</button>
            `).join('');

            document.getElementById('level-container').innerHTML = `
               <div class="level-image">
                     <img src="{{ asset('') }}${level.image}" min-height="300px" alt="${level.correct_word}" class="game-image">
                </div>
                <div class="word-options">${words}</div>
            `;
        }


        // Функция для проверки ответа
        function checkAnswer(selectedWord, correctWord) {
            if (selectedWord === correctWord) {
                document.getElementById('result').innerText = 'Правильно! 🎉';
                score += 10; // Добавляем 10 очков за правильный ответ
                document.getElementById('score').innerText = score;
            } else {
                document.getElementById('result').innerText = 'Неправильно. Попробуйте еще раз. 😢';
            }

            // Переход к следующему уровню
            setTimeout(() => {
                currentLevel++;
                loadLevel();
                document.getElementById('result').innerText = '';
            }, 1000);
        }

        // Загружаем первый уровень
        loadLevel();
    </script>

@endsection
