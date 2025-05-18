import { BaseGame } from './base-game.js';

class WordGame extends BaseGame {
    constructor() {
        super('word_game');
        this.setupGameSpecificListeners();
    }

    setupGameSpecificListeners() {
        document.querySelectorAll('.letter').forEach(letter => {
            letter.addEventListener('click', (e) => this.handleLetterClick(e));
        });

        // Обработчик для возврата букв (добавляем эту часть)
        document.querySelectorAll('.answer-area').forEach(area => {
            area.addEventListener('click', (e) => {
                if (e.target.classList.contains('letter')) {
                    this.moveLetterBack(e.target);
                }
            });
        });
    }
    // Новый метод для возврата буквы
    moveLetterBack(letter) {
        const answerArea = letter.closest('.answer-area');
        const originalLetter = this.findOriginalLetter(letter.dataset.letter);

        if (originalLetter) {
            originalLetter.style.visibility = 'visible';
        }
        letter.remove();

        // Сбрасываем проверку, если она была
        const feedback = answerArea.closest('.level').querySelector('.feedback-message');
        feedback.textContent = '';
        feedback.className = 'feedback-message';
    }

    handleLetterClick(event) {
        const letter = event.target;
        const answerArea = letter.closest('.level').querySelector('.answer-area');

        letter.style.visibility = 'hidden';
        const clonedLetter = letter.cloneNode(true);
        clonedLetter.style.backgroundColor = '#9b59b6';
        clonedLetter.style.visibility = 'visible';
        answerArea.appendChild(clonedLetter);

        // console.log(answerArea.children.length)
        // console.log(this.getCurrentWordLength())
        if (answerArea.children.length === this.getCurrentWordLength()) {
            this.checkAnswer(answerArea);
        }
    }

    findOriginalLetter(letter) {
        const activeLevel = document.querySelector('.level.active');
        return activeLevel?.querySelector(`.letter[data-letter="${letter}"][style*="visibility: hidden"]`);
    }

    getCurrentWordLength() {
        const activeLevel = document.querySelector('.level.active');
        // console.log(activeLevel)
        return activeLevel?.querySelector('.level-image').alt.length || 0;
    }

    checkAnswer(answerArea) {
        const userAnswer = Array.from(answerArea.children)
            .map(letter => letter.dataset.letter)
            .join('')
            .toLowerCase();

        // console.log(userAnswer)

        const correctWord = answerArea.closest('.level')
            .querySelector('.level-image').alt.toLowerCase();

        // console.log(correctWord)

        if (userAnswer === correctWord) {
            this.handleCorrectAnswer(answerArea);
        } else {
            this.handleIncorrectAnswer(answerArea);
        }
    }

    handleCorrectAnswer(answerArea) {
        this.currentScore += 10;
        console.log(this.currentScore)
        const feedback = answerArea.closest('.level').querySelector('.feedback-message');
        feedback.textContent = 'Правильно! 🎉';
        feedback.className = 'feedback-message correct-feedback';

        setTimeout(() => {
            this.proceedToNextLevel(answerArea.closest('.level'));
        }, 1000);
    }

    handleIncorrectAnswer(answerArea) {
        this.currentScore = Math.max(0, this.currentScore - 2);
        const feedback = answerArea.closest('.level').querySelector('.feedback-message');
        feedback.textContent = 'Попробуй еще раз! ❌';
        feedback.className = 'feedback-message incorrect-feedback';
        answerArea.style.borderColor = '#e74c3c';

        setTimeout(() => {
            answerArea.style.borderColor = '#3498db';
        }, 1000);
    }
}

// Инициализация игры при загрузке страницы
document.addEventListener('DOMContentLoaded', () => {
    new WordGame();
});