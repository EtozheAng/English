@extends('layouts.home')

@section('title', 'Соедини слова - Игра')

@section('content')
    <div class="game-container">
        <h1 class="game-title">Соедини слова</h1>

        <!-- Блок выбора уровня -->
        <div class="level-selection">
            <h2>Выберите уровень</h2>
            <div class="levels">
                @foreach ($levels as $index => $level)
                    @php $levelNumber = $index + 1; @endphp
                    <button class="level-btn" data-level="{{ $levelNumber }}">
                        Уровень {{ $levelNumber }}
                    </button>
                @endforeach
            </div>
        </div>

        <!-- Игровая область -->
        <div class="game-area hidden">
            <div class="game-header">
                <h2>Уровень <span id="current-level">1</span></h2>
            </div>

            <div class="message-area"></div>

            <div class="words-container">
                <div class="english-words">
                    <h3>Английские слова</h3>
                    <ul id="english-words-list" class="words-list"></ul>
                </div>
                <div class="russian-words">
                    <h3>Русские слова</h3>
                    <ul id="russian-words-list" class="words-list"></ul>
                </div>
            </div>

            <div class="game-result hidden">
                <h3>Уровень пройден!</h3>
                <p>Ваш результат: <span id="final-score">0</span> очков</p>
                <div class="result-buttons">
                    <button id="next-level-btn" class="btn btn-primary">Продолжить</button>
                    <button id="select-level-btn" class="btn btn-secondary">Выбрать уровень</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        const levelsData = @json($levels);
        let currentLevel = 0;
        let score = 0;
        let correctPairs = {};
        let selectedEnglishWord = null;
        let selectedRussianWord = null;
        let mistakesCount = 0;

        // Выбор уровня
        document.querySelectorAll('.level-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                currentLevel = parseInt(this.dataset.level) - 1;
                startLevel(currentLevel);
            });
        });

        // Кнопка "Продолжить"
        document.getElementById('next-level-btn').addEventListener('click', function() {
            if (currentLevel + 1 < levelsData.length) {
                currentLevel++;
                startLevel(currentLevel);
            } else {
                // Все уровни пройдены
                document.querySelector('.game-area').classList.add('hidden');
                document.querySelector('.level-selection').classList.remove('hidden');
            }
        });

        // Кнопка "Выбрать уровень"
        document.getElementById('select-level-btn').addEventListener('click', function() {
            document.querySelector('.game-area').classList.add('hidden');
            document.querySelector('.level-selection').classList.remove('hidden');
        });

        function startLevel(levelIndex) {
            const level = levelsData[levelIndex];
            document.getElementById('current-level').textContent = levelIndex + 1;
            document.querySelector('.game-area').classList.remove('hidden');
            document.querySelector('.level-selection').classList.add('hidden');
            document.querySelector('.game-result').classList.add('hidden');
            score = 0;
            mistakesCount = 0;
            selectedEnglishWord = null;
            selectedRussianWord = null;

            // Перемешиваем слова
            const shuffledEnglish = [...level.englishWords].sort(() => Math.random() - 0.5);
            const shuffledRussian = [...level.russianWords].sort(() => Math.random() - 0.5);

            // Отображаем слова
            const englishList = document.getElementById('english-words-list');
            const russianList = document.getElementById('russian-words-list');

            englishList.innerHTML = '';
            russianList.innerHTML = '';

            // Обработчики для английских слов
            shuffledEnglish.forEach(word => {
                const li = document.createElement('li');
                li.textContent = word;
                li.classList.add('word-item');
                li.dataset.word = word;
                li.addEventListener('click', function() {
                    // Сбрасываем предыдущее выделение
                    document.querySelectorAll('#english-words-list .word-item').forEach(item => {
                        item.classList.remove('selected');
                    });

                    // Выделяем новое слово
                    selectedEnglishWord = word;
                    li.classList.add('selected');

                    // Если уже выбрано русское слово - проверяем пару
                    if (selectedRussianWord) {
                        checkPair();
                    }
                });
                englishList.appendChild(li);
            });

            // Обработчики для русских слов
            shuffledRussian.forEach(word => {
                const li = document.createElement('li');
                li.textContent = word;
                li.classList.add('word-item');
                li.dataset.word = word;
                li.addEventListener('click', function() {
                    // Сбрасываем предыдущее выделение
                    document.querySelectorAll('#russian-words-list .word-item').forEach(item => {
                        item.classList.remove('selected');
                    });

                    // Выделяем новое слово
                    selectedRussianWord = word;
                    li.classList.add('selected');

                    // Если уже выбрано английское слово - проверяем пару
                    if (selectedEnglishWord) {
                        checkPair();
                    }
                });
                russianList.appendChild(li);
            });

            // Сохраняем правильные пары
            correctPairs = level.correctPairs;
        }

        function checkPair() {
            const englishWordElement = document.querySelector(`#english-words-list [data-word="${selectedEnglishWord}"]`);
            const russianWordElement = document.querySelector(`#russian-words-list [data-word="${selectedRussianWord}"]`);

            // Проверяем правильность пары
            if (correctPairs[selectedEnglishWord] === selectedRussianWord) {
                // Правильный ответ
                showMessage('Правильно!', 'success');

                // Подсвечиваем правильные слова
                englishWordElement.classList.add('correct');
                russianWordElement.classList.add('correct');

                // Удаляем слова после задержки
                setTimeout(() => {
                    englishWordElement.remove();
                    russianWordElement.remove();

                    // Сбрасываем выделение
                    selectedEnglishWord = null;
                    selectedRussianWord = null;

                    // Проверяем завершение уровня
                    if (document.getElementById('english-words-list').children.length === 0) {
                        completeLevel();
                    }
                }, 500);
            } else {
                // Неправильный ответ
                showMessage('Неверно', 'error');
                mistakesCount++;

                // Подсвечиваем неправильные слова
                englishWordElement.classList.add('wrong');
                russianWordElement.classList.add('wrong');

                // Сбрасываем выделение через секунду
                setTimeout(() => {
                    englishWordElement.classList.remove('selected', 'wrong');
                    russianWordElement.classList.remove('selected', 'wrong');
                    selectedEnglishWord = null;
                    selectedRussianWord = null;
                }, 1000);
            }
        }

        function completeLevel() {
            // Рассчитываем итоговый счет
            if (mistakesCount === 0) {
                score = 20; // Максимальный балл без ошибок
            } else {
                score = Math.max(15, 20 - mistakesCount); // Минимум 15 очков
            }

            document.getElementById('final-score').textContent = score;
            document.querySelector('.game-result').classList.remove('hidden');
        }

        function showMessage(text, type) {
            const messageArea = document.querySelector('.message-area');
            messageArea.innerHTML = `<div class="message ${type}">${text}</div>`;

            // Автоматически скрываем сообщение
            setTimeout(() => {
                messageArea.innerHTML = '';
            }, 2000);
        }
    </script>

    <style>
        .game-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        .game-title {
            text-align: center;
            color: #2c3e50;
        }

        .level-selection {
            text-align: center;
        }

        .levels {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            justify-content: center;
            margin-top: 20px;
        }

        .level-btn {
            padding: 10px 20px;
            font-size: 16px;
            background-color: #3490dc;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .level-btn:hover {
            background-color: #2779bd;
        }

        .game-area {
            margin-top: 20px;
        }

        .game-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .message-area {
            min-height: 40px;
            margin: 10px 0;
            text-align: center;
        }

        .message {
            padding: 10px;
            border-radius: 5px;
            display: inline-block;
        }

        .message.success {
            background-color: #d4edda;
            color: #155724;
        }

        .message.error {
            background-color: #f8d7da;
            color: #721c24;
        }

        .message.info {
            background-color: #d1ecf1;
            color: #0c5460;
        }

        .words-container {
            display: flex;
            justify-content: space-between;
            gap: 20px;
        }

        .english-words,
        .russian-words {
            flex: 1;
        }

        .words-list {
            list-style: none;
            padding: 0;
            min-height: 200px;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 10px;
        }

        .word-item {
            padding: 8px;
            margin: 5px 0;
            background-color: #f5f5f5;
            border-radius: 3px;
            cursor: pointer;
        }

        .word-item:hover {
            background-color: #e0e0e0;
        }

        .word-item.selected {
            background-color: #b3e0ff;
        }

        .word-item.correct {
            background-color: #d4edda;
        }

        .word-item.wrong {
            background-color: #f8d7da;
        }

        .game-result {
            text-align: center;
            margin-top: 20px;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 5px;
        }

        .result-buttons {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-top: 15px;
        }

        .btn {
            padding: 8px 16px;
            border-radius: 5px;
            cursor: pointer;
        }

        .btn-primary {
            background-color: #3490dc;
            color: white;
            border: none;
        }

        .btn-secondary {
            background-color: #e2e8f0;
            color: #4a5568;
            border: none;
        }

        .hidden {
            display: none;
        }
    </style>
@endsection
