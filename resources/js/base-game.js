export class BaseGame {
    constructor() {
        this.currentScore = 0;
        this.maxPossibleScore = 0;
        this.startTime = null;
        this.gameDuration = 0;
        this.bestScore = localStorage.getItem('bestScore') || 0;
        this.initializeGame();
    }

    initializeGame() {
        this.startTimer();
        this.calculateMaxPossibleScore();
        this.setupCommonEventListeners();
        // this.resetLevelsDisplay();
    }

    // Общие методы для всех игр
    startTimer() {
        this.startTime = new Date();
    }

    calculateMaxPossibleScore() {
        this.maxPossibleScore = document.querySelectorAll('.level').length * 10;
    }

    getGameDuration() {
        const endTime = new Date();
        this.gameDuration = Math.floor((endTime - this.startTime) / 1000);
        return this.formatTime(this.gameDuration);
    }

    formatTime(seconds) {
        const mins = Math.floor(seconds / 60);
        const secs = seconds % 60;
        return `${mins} мин ${secs} сек`;
    }

    setupCommonEventListeners() {
        document.querySelector('.restart-btn')?.addEventListener('click', () => this.restartGame());
        document.querySelector('.home-btn')?.addEventListener('click', () => this.goToHome());
    }

    resetLevelsDisplay() {
        document.querySelectorAll('.level').forEach((level, index) => {
            level.style.display = index === 0 ? 'block' : 'none';
        });
    }

    proceedToNextLevel(currentLevel) {
        currentLevel.style.display = 'none';
        const nextLevel = currentLevel.nextElementSibling;

        if (nextLevel?.classList.contains('level')) {
            nextLevel.style.display = 'block';
        } else {
            this.showFinalResults();
        }
    }

    showFinalResults() {
        const duration = this.getGameDuration();
        const isNewRecord = this.currentScore > this.bestScore;

        if (isNewRecord) {
            this.bestScore = this.currentScore;
            localStorage.setItem('bestScore', this.bestScore);
        }

        document.getElementById('results').innerHTML = this.generateResultsHTML(duration, isNewRecord);
        document.getElementById('results').style.display = 'block';
        document.querySelector('.action-buttons').style.display = 'flex';
    }

    generateResultsHTML(duration, isNewRecord) {
        return `
            <h2 class="results-title">Игра завершена! 🎉</h2>
            <div class="result-item">
                <span class="result-label">Время:</span>
                <span class="result-value">${duration}</span>
            </div>
            <div class="result-item">
                <span class="result-label">Очки:</span>
                <span class="result-value">${this.currentScore} из ${this.maxPossibleScore}</span>
            </div>
            ${this.bestScore ? `
            <div class="result-item">
                <span class="result-label">${isNewRecord ? '🎉 Новый рекорд!' : 'Лучший результат:'}</span>
                <span class="result-value">${this.bestScore}</span>
            </div>
            ` : ''}
            <div class="completion-message">Отличная работа!</div>
        `;
    }

    restartGame() {
        window.location.reload(); // Полная перезагрузка страницы
    }

    goToHome() {
        window.location.href = "/games";
    }
}