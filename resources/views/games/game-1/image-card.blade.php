@extends('layouts.home')

@section('title', 'Игры для детей')

@vite(['resources/js/image-card-game.js'])

@section('content')
    <style>
        .game-container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }

        .game-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .game-title {
            color: #2c3e50;
            font-size: 2.2rem;
            margin-bottom: 10px;
        }

        .level {
            display: none;
            margin: 0 auto 30px;
            padding: 25px;
            background-color: #fff;
            border-radius: 15px;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
            max-width: 530px;
            animation: fadeIn 0.5s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .level.active {
            display: block;
        }

        .level-image-container {
            display: flex;
            margin-bottom: 20px;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            position: relative;
            min-height: 330px;
        }

        .level-image {
            object-fit: cover;
            width: 100%;
            display: block;
            transition: transform 0.3s ease;
        }

        .level-image:hover {
            transform: scale(1.02);
        }

        .words-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
            margin-top: 20px;
        }

        .word-option {
            padding: 15px;
            background-color: #3498db;
            color: white;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 600;
            text-align: center;
            border: none;
            font-size: 1rem;
        }

        .word-option:hover {
            background-color: #2980b9;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
        }

        .word-option.correct {
            background-color: #2ecc71 !important;
            transform: scale(1.05);
        }

        .word-option.incorrect {
            background-color: #e74c3c !important;
        }

        .feedback-message {
            margin-top: 20px;
            font-size: 1.3rem;
            font-weight: bold;
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .correct-feedback {
            color: #27ae60;
        }

        .incorrect-feedback {
            color: #e74c3c;
        }

        .results-panel {
            display: none;
            text-align: center;
            margin: 30px auto;
            padding: 25px;
            background-color: #f8f9fa;
            border-radius: 15px;
            max-width: 500px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            animation: fadeIn 0.5s ease;
        }

        .results-title {
            color: #2c3e50;
            margin-bottom: 15px;
        }

        .score-display {
            font-size: 1.2rem;
            margin: 15px 0;
        }

        .action-buttons {
            display: none;
            justify-content: center;
            gap: 15px;
            margin-top: 30px;
            flex-wrap: wrap;
        }

        .action-btn {
            padding: 12px 25px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s ease;
            font-size: 1rem;
        }

        .restart-btn {
            background-color: #3498db;
            color: white;
        }

        .restart-btn:hover {
            background-color: #2980b9;
            transform: translateY(-2px);
        }

        .home-btn {
            background-color: #7f8c8d;
            color: white;
        }

        .home-btn:hover {
            background-color: #6c7a7d;
            transform: translateY(-2px);
        }

        .result-item {
            margin: 15px 0;
            display: flex;
            justify-content: space-between;
            max-width: 300px;
            margin-left: auto;
            margin-right: auto;
        }

        .result-label {
            font-weight: 600;
            color: #555;
        }

        .result-value {
            font-weight: 700;
            color: #2c3e50;
        }

        .completion-message {
            margin-top: 20px;
            font-size: 1.2rem;
            color: #27ae60;
            font-weight: 600;
            padding: 10px;
            background-color: #e8f5e9;
            border-radius: 8px;
        }


        /* Адаптивность */
        @media (max-width: 576px) {
            .words-grid {
                grid-template-columns: 1fr;
            }

            .level {
                padding: 20px 15px;
            }

            .word-option {
                padding: 12px;
            }
        }
    </style>

    <div class="game-container">
        <div class="game-header">
            <h1 class="game-title">Выбери правильный ответ</h1>
        </div>

        <!-- Уровни игры -->
        <div class="levels-wrapper">
            @foreach ($levels as $index => $level)
                <div class="level {{ $index === 0 ? 'active' : '' }}" data-level="{{ $index }}">
                    <div class="level-image-container">
                        <img src="{{ asset($level['image']) }}" alt="{{ $level['correct_word'] }}" class="level-image">
                    </div>

                    <div class="words-grid">
                        @foreach ($level['words'] as $word)
                            <button class="word-option"
                                data-correct="{{ $word === $level['correct_word'] ? 'true' : 'false' }}">
                                {{ $word }}
                            </button>
                        @endforeach
                    </div>

                    <div class="feedback-message" id="message-{{ $index }}"></div>
                </div>
            @endforeach
        </div>

        <!-- Панель результатов -->
        <div class="results-panel" id="results">
            <h2 class="results-title">Результаты</h2>
            <div class="score-display">
                Вы набрали: <span id="final-score" style="font-weight:800;">0</span> очков!
            </div>
        </div>

        <!-- Кнопки действий -->
        <div class="action-buttons">
            <button class="action-btn restart-btn">Начать заново</button>
            <button class="action-btn home-btn">Вернуться на главную</button>
        </div>
    </div>
@endsection
