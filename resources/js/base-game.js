export class BaseGame {
    constructor(gameId = 'default_game') {
        this.gameId = gameId; // Уникальный ID игры ('missing_letter', 'word_match' и т.д.)
        this.bestScoreKey = `bestScore_${this.gameId}`; // Ключ для localStorage
        this.currentScore = 0;
        this.maxPossibleScore = 0;
        this.startTime = null;
        this.gameDuration = 0;
        this.bestScore = parseInt(localStorage.getItem(this.bestScoreKey)) || 0;
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

    proceedToNextLevel(currentLevel) {
        currentLevel.classList.remove('active');
        const nextLevel = currentLevel.nextElementSibling;

        if (nextLevel?.classList.contains('level')) {
            nextLevel.classList.add('active')
        } else {
            this.showFinalResults();
        }
    }

    async showFinalResults() {
        const duration = this.getGameDuration();
        const isNewRecord = this.currentScore > this.bestScore;

        // Извлекаем последнюю часть URL (например, "fruits" из "/games/image-card/fruits")
        const pathParts = window.location.pathname.split('/');
        const section = pathParts[pathParts.length - 1]; // Получаем последний элемент массива
        if (isNewRecord) {
            try {
                // Отправляем данные на сервер Laravel
                const response = await fetch('/api/save-score', {
                    method: 'POST',
                    credentials: 'include', // Важно!
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'X-Requested-With': 'XMLHttpRequest' // Важно!
                    },
                    body: JSON.stringify({
                        score: this.currentScore,
                        game_type: this.gameId,
                        section: section
                    })
                });

                if (response.ok) {
                    // const data = await response.json();
                    this.bestScore = this.currentScore; // Обновляем лучший счет из ответа сервера
                    localStorage.setItem(this.bestScoreKey, this.currentScore);
                } else {
                    console.error('Ошибка при сохранении результата');
                    localStorage.setItem(this.bestScoreKey, this.currentScore);
                }
            } catch (error) {
                console.error('Ошибка сети:', error);
                localStorage.setItem(this.bestScoreKey, this.currentScore);
            }
        } else {
            this.bestScore = localStorage.getItem(this.bestScoreKey);
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