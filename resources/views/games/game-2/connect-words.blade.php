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
        class WordMatchingGame {
            constructor(levelsData) {
                this.levelsData = levelsData;
                this.currentLevel = 0;
                this.score = 0;
                this.bestScoreKey = `bestScore_word-matching`; // Ключ для localStorage
                this.bestScore = parseInt(localStorage.getItem(this.bestScoreKey)) || 0;
                this.correctPairs = {};
                this.selectedEnglishWord = null;
                this.selectedRussianWord = null;
                this.mistakesCount = 0;

                this.initElements();
                this.bindEvents();
            }

            initElements() {
                this.elements = {
                    levelButtons: document.querySelectorAll('.level-btn'),
                    nextLevelBtn: document.getElementById('next-level-btn'),
                    selectLevelBtn: document.getElementById('select-level-btn'),
                    currentLevelDisplay: document.getElementById('current-level'),
                    gameArea: document.querySelector('.game-area'),
                    levelSelection: document.querySelector('.level-selection'),
                    gameResult: document.querySelector('.game-result'),
                    englishWordsList: document.getElementById('english-words-list'),
                    russianWordsList: document.getElementById('russian-words-list'),
                    finalScore: document.getElementById('final-score'),
                    messageArea: document.querySelector('.message-area')
                };
            }

            bindEvents() {
                // Выбор уровня
                this.elements.levelButtons.forEach(btn => {
                    btn.addEventListener('click', () => {
                        this.currentLevel = parseInt(btn.dataset.level) - 1;
                        this.startLevel(this.currentLevel);
                    });
                });

                // Кнопка "Продолжить"
                this.elements.nextLevelBtn.addEventListener('click', () => {
                    if (this.currentLevel + 1 < this.levelsData.length) {
                        this.currentLevel++;
                        this.startLevel(this.currentLevel);
                    } else {
                        this.showLevelSelection();
                    }
                });

                // Кнопка "Выбрать уровень"
                this.elements.selectLevelBtn.addEventListener('click', () => {
                    this.showLevelSelection();
                });
            }

            startLevel(levelIndex) {
                const level = this.levelsData[levelIndex];
                this.resetGameState(levelIndex);
                this.correctPairs = level.correctPairs;

                this.displayWords(level);
                this.showGameArea();
            }

            resetGameState(levelIndex) {
                this.elements.currentLevelDisplay.textContent = levelIndex + 1;
                this.score = 0;
                this.mistakesCount = 0;
                this.selectedEnglishWord = null;
                this.selectedRussianWord = null;
                this.elements.englishWordsList.innerHTML = '';
                this.elements.russianWordsList.innerHTML = '';
                this.elements.gameResult.classList.add('hidden');
            }

            displayWords(level) {
                const shuffledEnglish = [...level.englishWords].sort(() => Math.random() - 0.5);
                const shuffledRussian = [...level.russianWords].sort(() => Math.random() - 0.5);

                this.createWordElements(shuffledEnglish, this.elements.englishWordsList, 'english');
                this.createWordElements(shuffledRussian, this.elements.russianWordsList, 'russian');
            }

            createWordElements(words, container, language) {
                container.innerHTML = '';

                words.forEach(word => {
                    const li = document.createElement('li');
                    li.textContent = word;
                    li.classList.add('word-item');
                    li.dataset.word = word;

                    li.addEventListener('click', () => {
                        this.handleWordSelection(word, language);
                    });

                    container.appendChild(li);
                });
            }

            handleWordSelection(word, language) {
                // Сбрасываем предыдущее выделение
                const listId = `${language}-words-list`;
                document.querySelectorAll(`#${listId} .word-item`).forEach(item => {
                    item.classList.remove('selected');
                });

                // Выделяем новое слово
                if (language === 'english') {
                    this.selectedEnglishWord = word;
                } else {
                    this.selectedRussianWord = word;
                }

                document.querySelector(`#${listId} [data-word="${word}"]`).classList.add('selected');

                // Если выбраны оба слова - проверяем пару
                if (this.selectedEnglishWord && this.selectedRussianWord) {
                    this.checkPair();
                }
            }

            checkPair() {
                const englishWordElement = this.getWordElement(this.selectedEnglishWord, 'english');
                const russianWordElement = this.getWordElement(this.selectedRussianWord, 'russian');

                if (this.correctPairs[this.selectedEnglishWord] === this.selectedRussianWord) {
                    this.handleCorrectPair(englishWordElement, russianWordElement);
                } else {
                    this.handleWrongPair(englishWordElement, russianWordElement);
                }
            }

            getWordElement(word, language) {
                return document.querySelector(`#${language}-words-list [data-word="${word}"]`);
            }

            handleCorrectPair(englishElement, russianElement) {
                this.showMessage('Правильно!', 'success');

                englishElement.classList.add('correct');
                russianElement.classList.add('correct');

                setTimeout(() => {
                    englishElement.remove();
                    russianElement.remove();

                    this.selectedEnglishWord = null;
                    this.selectedRussianWord = null;

                    if (this.elements.englishWordsList.children.length === 0) {
                        this.completeLevel();
                    }
                }, 500);
            }

            handleWrongPair(englishElement, russianElement) {
                this.showMessage('Неверно', 'error');
                this.mistakesCount++;

                englishElement.classList.add('wrong');
                russianElement.classList.add('wrong');

                setTimeout(() => {
                    englishElement.classList.remove('selected', 'wrong');
                    russianElement.classList.remove('selected', 'wrong');
                    this.selectedEnglishWord = null;
                    this.selectedRussianWord = null;
                }, 1000);
            }

            completeLevel() {
                this.score = this.mistakesCount === 0 ? 20 : Math.max(15, 20 - this.mistakesCount);

                this.elements.finalScore.textContent = this.score;
                this.elements.gameResult.classList.remove('hidden');

                const isNewRecord = this.score > this.bestScore;
                if (isNewRecord) {
                    this.bestScore = this.score;
                    localStorage.setItem(this.bestScoreKey, this.bestScore);
                }
            }

            showMessage(text, type) {
                this.elements.messageArea.innerHTML = `<div class="message ${type}">${text}</div>`;

                setTimeout(() => {
                    this.elements.messageArea.innerHTML = '';
                }, 2000);
            }

            showGameArea() {
                this.elements.gameArea.classList.remove('hidden');
                this.elements.levelSelection.classList.add('hidden');
            }

            showLevelSelection() {
                this.elements.gameArea.classList.add('hidden');
                this.elements.levelSelection.classList.remove('hidden');
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            const levelsData = @json($levels);
            const game = new WordMatchingGame(levelsData);
        });
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
