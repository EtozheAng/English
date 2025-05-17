@extends('layouts.home')

@section('title', 'Игры для детей')


{{-- @vite(['resources/js/create-words.js']) --}}
@vite(['resources/js/word-game.js'])

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
            max-width: 500px;
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
            margin-bottom: 20px;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            position: relative;
            min-height: 330px;
        }

        .level-image {
            width: 100%;
            display: block;
            transition: transform 0.3s ease;
        }

        .level-image:hover {
            transform: scale(1.02);
        }

        .words-grid {
            /* display: grid;
                                                                                                                                grid-template-columns: repeat(2, 1fr); */
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            margin-top: 20px;
        }

        .word-option {
            flex: 1;
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
            <h1 class="game-title">Составьте слово из букв</h1>
        </div>

        <!-- Уровни игры -->
        <div class="levels-wrapper">
            @foreach ($levels as $index => $level)
                <div class="level {{ $index === 0 ? 'active' : '' }}" data-level="{{ $index }}"">
                    <div class="level-image-container">
                        <img src="{{ asset($level['image']) }}" alt="{{ $level['correct_word'] }}" class="level-image">
                    </div>

                    <!-- Область для составления слова -->
                    <div class="answer-area" id="answer-area-{{ $index }}"
                        style="min-height: 50px; border: 2px dashed #3498db; border-radius: 8px; padding: 10px; margin: 20px 0; display: flex; flex-wrap: wrap; gap: 5px; align-items: center;">
                        <!-- Сюда будут добавляться буквы по клику -->
                    </div>

                    <!-- Буквы для выбора -->
                    <div class="letters-grid"
                        style="display: flex; flex-wrap: wrap; gap: 10px; justify-content: center; margin-top: 20px;">
                        @foreach ($level['separate'] as $letter)
                            <div class="letter" data-letter="{{ $letter }}"
                                style="width: 40px; height: 40px; background-color: #3498db; color: white; display: flex; align-items: center; justify-content: center; border-radius: 5px; font-size: 1.2rem; cursor: pointer; user-select: none;">
                                {{ $letter }}
                            </div>
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

{{-- <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Инициализация всех уровней
        document.querySelectorAll('.level').forEach(level => {
            const answerArea = level.querySelector('.answer-area');
            const lettersGrid = level.querySelector('.letters-grid');
            const checkButton = level.querySelector('.check-answer');
            const feedback = level.querySelector('.feedback-message');
            const correctWord = level.querySelector('.level-image').alt.toLowerCase();

            // Обработчик клика для букв в исходной сетке
            lettersGrid.addEventListener('click', function(e) {
                if (e.target.classList.contains('letter')) {
                    moveLetterToAnswer(e.target, level);
                }
            });

            // Обработчик клика для букв в области ответа
            answerArea.addEventListener('click', function(e) {
                if (e.target.classList.contains('letter')) {
                    moveLetterBack(e.target, level);
                }
            });

            // Функция перемещения буквы в область ответа
            function moveLetterToAnswer(letter, level) {
                const answerArea = level.querySelector('.answer-area');
                const clonedLetter = letter.cloneNode(true);

                clonedLetter.style.backgroundColor = '#9b59b6';
                answerArea.appendChild(clonedLetter);
                letter.style.visibility = 'hidden';

                // Автопроверка при наборе нужного количества букв
                if (answerArea.children.length === correctWord.length) {
                    checkAnswer(level);
                }
            }

            // Функция возврата буквы обратно
            function moveLetterBack(letter, level) {
                const lettersGrid = level.querySelector('.letters-grid');
                const originalLetter = lettersGrid.querySelector(
                    `[data-letter="${letter.dataset.letter}"][style*="visibility: hidden"]`);

                if (originalLetter) {
                    originalLetter.style.visibility = 'visible';
                }
                letter.remove();
            }

            // Функция проверки ответа
            function checkAnswer(level) {
                const answerArea = level.querySelector('.answer-area');
                let userAnswer = '';

                Array.from(answerArea.children).forEach(letter => {
                    userAnswer += letter.dataset.letter.toLowerCase();
                });

                if (userAnswer === correctWord) {
                    feedback.innerHTML =
                        `<span class="correct-feedback">Правильно! Это слово "${correctWord}"</span>`;
                    feedback.style.display = 'block';

                    // Переход к следующему уровню
                    setTimeout(() => {
                        const nextLevel = level.nextElementSibling;
                        if (nextLevel && nextLevel.classList.contains('level')) {
                            level.classList.remove('active');
                            nextLevel.classList.add('active');
                        } else {
                            document.getElementById('results').style.display = 'block';
                            document.querySelector('.action-buttons').style.display = 'flex';
                        }
                    }, 1500);
                } else {
                    feedback.innerHTML =
                        `<span class="incorrect-feedback">Неверно. Попробуйте еще раз</span>`;
                    feedback.style.display = 'block';

                    // Подсветка ошибки
                    answerArea.style.borderColor = '#e74c3c';
                    setTimeout(() => {
                        answerArea.style.borderColor = '#3498db';
                    }, 1000);
                }
            }
        });

        // Обработчики для кнопок действий
        document.querySelector('.restart-btn')?.addEventListener('click', () => location.reload());
        document.querySelector('.home-btn')?.addEventListener('click', () => window.location.href = '/');
    });
</script> --}}
