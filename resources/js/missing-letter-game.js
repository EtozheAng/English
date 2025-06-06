import { BaseGame } from './base-game.js';

class MissingLetterGame extends BaseGame {
    constructor() {
        super('missing_letter');
        this.levelCompleted = false;
        this.setupEventListeners();
    }

    setupEventListeners() {

        // Обработка кнопки проверки
        document.querySelectorAll('.check-btn').forEach(btn => {
            btn.addEventListener('click', (e) => {
                // console.log(e.target); // Отладка
                // const level = e.target.closest('.level');
                const level = document.querySelector('.level.active')
                if (level) {
                    this.checkAnswer(level);
                }
            });
        });

        // Проверка по Enter
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Enter') {
                console.log('Enter key pressed'); // Отладка
                const activeLevel = document.querySelector('.level.active');
                if (activeLevel) {
                    this.checkAnswer(activeLevel);
                }
            }
        });
    }

    checkAnswer(level) {

        if (this.levelCompleted) {
            console.log('Level already completed');
            return;
        }

        const input = level.querySelector('.letter-input');
        const missingLetter = level.querySelector('.letter.missing');
        const feedback = level.querySelector('.feedback');

        if (!input || !missingLetter || !feedback) {
            console.error('Required elements not found');
            return;
        }

        const userAnswer = input.value.trim().toLowerCase();
        const correctLetter = missingLetter.dataset.correct;

        // console.log('User:', userAnswer, 'Correct:', correctLetter);

        if (userAnswer === correctLetter) {
            this.handleCorrectAnswer(level, feedback, correctLetter, input);
        } else {
            this.handleIncorrectAnswer(feedback, input);
        }
    }

    handleCorrectAnswer(level, feedback, correctLetter, input) {
        const missingLetterElem = level.querySelector('.letter.missing');
        missingLetterElem.textContent = correctLetter.toLowerCase();
        missingLetterElem.classList.add('correct-letter');

        input.disabled = true;
        level.querySelector('.check-btn').disabled = true;

        this.currentScore += 10;

        feedback.textContent = 'Правильно!';
        feedback.className = 'feedback correct';
        this.levelCompleted = true;

        setTimeout(() => {
            this.proceedToNextLevel(level);
            this.levelCompleted = false;
        }, 1500);
    }

    handleIncorrectAnswer(feedback, input) {
        this.currentScore = Math.max(0, this.currentScore - 2);
        feedback.textContent = 'Попробуйте еще раз';
        feedback.className = 'feedback incorrect';
        input.value = '';
        input.focus();
    }

    proceedToNextLevel(currentLevel) {
        console.log('Proceeding to next level');

        currentLevel.classList.remove('active');
        const nextLevel = currentLevel.nextElementSibling;

        if (nextLevel) {
            nextLevel.classList.add('active');
            const nextInput = nextLevel.querySelector('.letter-input');
            if (nextInput) nextInput.focus();
        } else {
            this.showFinalResults();
        }
    }

}

// Инициализация
document.addEventListener('DOMContentLoaded', () => {
    new MissingLetterGame();
});