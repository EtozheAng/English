class ImageCardGame {
    constructor() {
        this.currentScore = 0;
        this.maxPossibleScore = 0;
        this.startTime = null;
        this.gameDuration = 0;
        this.bestScore = localStorage.getItem('bestScore') || 0;
        this.initGame();
    }

    initGame() {
        this.setupEventListeners();
        this.resetLevelsDisplay();
        this.calculateMaxPossibleScore();
        this.startTimer();
    }

    startTimer() {
        this.startTime = new Date();
    }

    calculateMaxPossibleScore() {
        const levelsCount = document.querySelectorAll('.level').length;
        this.maxPossibleScore = levelsCount * 10; // 10 очков за каждый уровень
    }

    getGameDuration() {
        const endTime = new Date();
        this.gameDuration = Math.floor((endTime - this.startTime) / 1000); // в секундах
        return this.formatTime(this.gameDuration);
    }

    formatTime(seconds) {
        const mins = Math.floor(seconds / 60);
        const secs = seconds % 60;
        return `${mins} мин ${secs} сек`;
    }

    setupEventListeners() {
        document.querySelectorAll('.word-option').forEach(option => {
            option.addEventListener('click', (e) => this.handleAnswerSelection(e));
        });

        document.querySelector('.restart-btn').addEventListener('click', () => this.restartGame());
        document.querySelector('.home-btn').addEventListener('click', () => this.goToHome());
    }

    handleAnswerSelection(event) {
        const selectedOption = event.target;
        const isCorrect = selectedOption.dataset.correct === 'true';
        const currentLevel = selectedOption.closest('.level');
        const feedbackElement = currentLevel.querySelector('.feedback-message');

        if (isCorrect) {
            this.handleCorrectAnswer(selectedOption, currentLevel, feedbackElement);
        } else {
            this.handleIncorrectAnswer(selectedOption, feedbackElement);
        }
    }

    handleCorrectAnswer(selectedOption, currentLevel, feedbackElement) {
        selectedOption.classList.add('correct');
        this.disableAllOptions(currentLevel);
        this.currentScore += 10;

        feedbackElement.textContent = 'Правильно! 🎉';
        feedbackElement.className = 'feedback-message correct-feedback';

        setTimeout(() => {
            this.proceedToNextLevel(currentLevel);
        }, 1000);
    }

    proceedToNextLevel(currentLevel) {
        currentLevel.style.display = 'none';
        const nextLevel = currentLevel.nextElementSibling;

        if (nextLevel && nextLevel.classList.contains('level')) {
            nextLevel.style.display = 'block';
        } else {
            this.showFinalResults();
        }
    }

    resetLevelsDisplay() {
        // Показываем только первый уровень
        document.querySelectorAll('.level').forEach((level, index) => {
            level.style.display = index === 0 ? 'block' : 'none';
        });
    }

    handleIncorrectAnswer(selectedOption, feedbackElement) {
        // Визуальные эффекты
        selectedOption.classList.add('incorrect');
        selectedOption.style.pointerEvents = 'none';

        // Штрафные очки
        this.currentScore = Math.max(0, this.currentScore - 2);

        // Отображение сообщения
        feedbackElement.textContent = 'Попробуй еще раз! ❌';
        feedbackElement.className = 'feedback-message incorrect-feedback';
    }

    disableAllOptions(level) {
        level.querySelectorAll('.word-option').forEach(option => {
            option.style.pointerEvents = 'none';
        });
    }

    showFinalResults() {
        const duration = this.getGameDuration();
        const isNewRecord = this.currentScore > this.bestScore;

        if (isNewRecord) {
            this.bestScore = this.currentScore;
            localStorage.setItem('bestScore', this.bestScore);
        }

        const resultsHTML = `
            <h2 class="results-title">Уровень пройден! 🎉</h2>
            <div class="result-item">
                <span class="result-label">Время игры:</span>
                <span class="result-value">${duration}</span>
            </div>
            <div class="result-item">
                <span class="result-label">Набрано очков:</span>
                <span class="result-value">${this.currentScore} из ${this.maxPossibleScore}</span>
            </div>
            ${this.bestScore ? `
            <div class="result-item">
                <span class="result-label">${isNewRecord ? '🎉 Новый рекорд!' : 'Ваш рекорд:'}</span>
                <span class="result-value">${this.bestScore}</span>
            </div>
            ` : ''}
            <div class="completion-message">Вы молодец! Так держать!</div>
        `;

        document.getElementById('results').innerHTML = resultsHTML;
        document.getElementById('results').style.display = 'block';
        document.querySelector('.action-buttons').style.display = 'flex';
    }

    restartGame() {
        // Сброс счета
        this.currentScore = 0;
        this.startTimer();

        // Скрытие результатов
        document.getElementById('results').style.display = 'none';
        document.querySelector('.action-buttons').style.display = 'none';

        // Сброс уровней
        document.querySelectorAll('.level').forEach((level, index) => {
            level.style.display = index === 0 ? 'block' : 'none';

            // Сброс состояния вариантов ответа
            level.querySelectorAll('.word-option').forEach(option => {
                option.classList.remove('correct', 'incorrect');
                option.style.pointerEvents = 'auto';
            });

            // Очистка сообщений
            level.querySelector('.feedback-message').textContent = '';
            level.querySelector('.feedback-message').className = 'feedback-message';
        });
    }

    goToHome() {
        window.location.href = "{{ route('games.sections') }}";
    }
}

// Инициализация игры при загрузке страницы
document.addEventListener('DOMContentLoaded', () => {
    new ImageCardGame();
});