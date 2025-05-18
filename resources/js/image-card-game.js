import { BaseGame } from './base-game.js';

class ImageCardGame extends BaseGame {
    constructor() {
        super('image-card');
        this.setupGameSpecificListeners();
    }

    setupGameSpecificListeners() {
        document.querySelectorAll('.word-option').forEach(option => {
            option.addEventListener('click', (e) => this.handleOptionClick(e));
        });
    }

    handleOptionClick(event) {
        const option = event.target;
        const isCorrect = option.dataset.correct === 'true';
        const currentLevel = option.closest('.level');

        if (isCorrect) {
            this.handleCorrectAnswer(option, currentLevel);
        } else {
            this.handleIncorrectAnswer(option, currentLevel);
        }
    }

    handleCorrectAnswer(option, level) {
        option.classList.add('correct');
        this.disableAllOptions(level);
        this.currentScore += 10;
        console.log(this.currentScore)

        const feedback = level.querySelector('.feedback-message');
        feedback.textContent = 'Правильно! 🎉';
        feedback.className = 'feedback-message correct-feedback';

        setTimeout(() => {
            this.proceedToNextLevel(level);
        }, 1000);
    }

    handleIncorrectAnswer(option, level) {
        option.classList.add('incorrect');
        this.currentScore = Math.max(0, this.currentScore - 2);

        const feedback = level.querySelector('.feedback-message');
        feedback.textContent = 'Попробуй еще раз! ❌';
        feedback.className = 'feedback-message incorrect-feedback';
    }

    disableAllOptions(level) {
        level.querySelectorAll('.word-option').forEach(option => {
            option.style.pointerEvents = 'none';
        });
    }
}

// Инициализация игры при загрузке страницы
document.addEventListener('DOMContentLoaded', () => {
    new ImageCardGame();
});