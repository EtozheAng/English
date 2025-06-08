import { BaseGame } from './base-game.js';

class AudioQuizGame extends BaseGame {
    constructor() {
        super('audio-quiz');
        this.audioPlayer = new Audio();
        this.setupGameListeners();
    }

    setupGameListeners() {
        // Обработчик кнопки воспроизведения звука
        document.querySelectorAll('.play-button').forEach(button => {
            button.addEventListener('click', (e) => {
                const audioSrc = e.currentTarget.dataset.audio;
                this.playAudio(audioSrc);
            });
        });

        // Обработчики вариантов ответов
        document.querySelectorAll('.word-option').forEach(option => {
            option.addEventListener('click', (e) => this.handleAnswerSelection(e.target));
        });
    }

    playAudio(src) {
        this.audioPlayer.pause();
        this.audioPlayer.src = src;
        this.audioPlayer.play().catch(e => console.error("Audio play error:", e));
    }

    handleAnswerSelection(selectedOption) {
        const isCorrect = selectedOption.dataset.correct === 'true';
        const currentLevel = selectedOption.closest('.level');

        if (isCorrect) {
            this.handleCorrectAnswer(selectedOption, currentLevel);
        } else {
            this.handleIncorrectAnswer(selectedOption, currentLevel);
        }
    }

    handleCorrectAnswer(option, level) {
        option.classList.add('correct');
        this.disableAllOptions(level);
        this.currentScore += 10;

        const feedback = level.querySelector('.feedback-message');
        feedback.textContent = 'Правильно! 🎉';
        feedback.className = 'feedback-message correct-feedback';

        setTimeout(() => {
            this.audioPlayer.pause();
            this.proceedToNextLevel(level);
        }, 1500);
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
            option.disabled = true;
        });
    }

    proceedToNextLevel(currentLevel) {
        this.audioPlayer.pause();
        super.proceedToNextLevel(currentLevel);
    }

    restartGame() {
        this.audioPlayer.pause();
        super.restartGame();
    }
}

// Инициализация игры
document.addEventListener('DOMContentLoaded', () => {
    new AudioQuizGame();
});