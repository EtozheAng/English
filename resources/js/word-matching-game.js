import { BaseGame } from './base-game.js';

export class WordMatchingGame extends BaseGame {
    constructor(levelsData) {
        super('word_matching');
        this.levelsData = levelsData;
        this.currentLevel = 0;
        this.correctPairs = {};
        this.selectedEnglishWord = null;
        this.selectedRussianWord = null;
        this.mistakesCount = 0;

        this.initElements();
        this.bindEvents();
        this.calculateMaxPossibleScore();
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
            messageArea: document.querySelector('.message-area'),
            results: document.getElementById('results'),
            actionButtons: document.querySelector('.action-buttons')
        };
    }

    bindEvents() {
        this.elements.levelButtons.forEach(btn => {
            btn.addEventListener('click', () => {
                this.currentLevel = parseInt(btn.dataset.level) - 1;
                this.startLevel(this.currentLevel);
            });
        });

        this.elements.nextLevelBtn.addEventListener('click', () => {
            if (this.currentLevel + 1 < this.levelsData.length) {
                this.currentLevel++;
                this.startLevel(this.currentLevel);
            } else {
                this.showFinalResults();
            }
        });

        this.elements.selectLevelBtn.addEventListener('click', () => {
            this.showLevelSelection();
        });
    }

    calculateMaxPossibleScore() {
        this.maxPossibleScore = this.levelsData.length * 20;
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
        this.mistakesCount = 0;
        this.selectedEnglishWord = null;
        this.selectedRussianWord = null;
        this.elements.englishWordsList.innerHTML = '';
        this.elements.russianWordsList.innerHTML = '';
        this.elements.gameResult.classList.add('hidden');
        this.elements.results.style.display = 'none';
        this.elements.actionButtons.style.display = 'none';
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
        const listId = `${language}-words-list`;
        document.querySelectorAll(`#${listId} .word-item`).forEach(item => {
            item.classList.remove('selected');
        });

        if (language === 'english') {
            this.selectedEnglishWord = word;
        } else {
            this.selectedRussianWord = word;
        }

        document.querySelector(`#${listId} [data-word="${word}"]`).classList.add('selected');

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
        const levelScore = this.mistakesCount === 0 ? 20 : Math.max(15, 20 - this.mistakesCount);
        this.currentScore += levelScore;
        this.elements.finalScore.textContent = levelScore;
        this.elements.gameResult.classList.remove('hidden');

        if (this.currentLevel + 1 >= this.levelsData.length) {
            this.showFinalResults();
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