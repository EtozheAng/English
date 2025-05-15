class WordGame {
    constructor(levelElement) {
        this.levelElement = levelElement;
        this.answerArea = levelElement.querySelector('.answer-area');
        this.lettersGrid = levelElement.querySelector('.letters-grid');
        this.checkButton = levelElement.querySelector('.check-answer');
        this.feedback = levelElement.querySelector('.feedback-message');
        this.correctWord = levelElement.querySelector('.level-image').alt.toLowerCase();

        this.mistakes = 0;
        this.levelCompleted = false;

        this.initEventListeners();
    }

    initEventListeners() {
        this.lettersGrid.addEventListener('click', (e) => {
            if (e.target.classList.contains('letter')) {
                this.moveLetterToAnswer(e.target);
            }
        });

        this.answerArea.addEventListener('click', (e) => {
            if (e.target.classList.contains('letter')) {
                this.moveLetterBack(e.target);
            }
        });

        if (this.checkButton) {
            this.checkButton.addEventListener('click', () => this.checkAnswer());
        }
    }

    moveLetterToAnswer(letter) {
        const clonedLetter = letter.cloneNode(true);
        clonedLetter.style.backgroundColor = '#9b59b6';
        this.answerArea.appendChild(clonedLetter);
        letter.style.visibility = 'hidden';

        if (this.answerArea.children.length === this.correctWord.length) {
            this.checkAnswer();
        }
    }

    moveLetterBack(letter) {
        const originalLetter = this.lettersGrid.querySelector(
            `[data-letter="${letter.dataset.letter}"][style*="visibility: hidden"]`);

        if (originalLetter) {
            originalLetter.style.visibility = 'visible';
        }
        letter.remove();
    }

    checkAnswer() {
        if (this.levelCompleted) return;

        let userAnswer = '';
        Array.from(this.answerArea.children).forEach(letter => {
            userAnswer += letter.dataset.letter.toLowerCase();
        });

        if (userAnswer === this.correctWord) {
            const levelScore = Math.max(10 - this.mistakes, 5);
            GameController.totalScore += levelScore;

            this.showFeedback(`Правильно! Это слово "${this.correctWord}". Вы заработали ${levelScore} очков`, true);
            this.levelCompleted = true;
            this.proceedToNextLevel();
        } else {
            this.mistakes++;
            this.showFeedback('Неверно. Попробуйте еще раз', false);
            this.highlightError();
        }
    }

    showFeedback(message, isCorrect) {
        this.feedback.innerHTML =
            `<span class="${isCorrect ? 'correct' : 'incorrect'}-feedback">${message}</span>`;
        this.feedback.style.display = 'block';
    }

    highlightError() {
        this.answerArea.style.borderColor = '#e74c3c';
        setTimeout(() => {
            this.answerArea.style.borderColor = '#3498db';
        }, 1000);
    }

    proceedToNextLevel() {
        setTimeout(() => {
            const nextLevel = this.levelElement.nextElementSibling;
            if (nextLevel && nextLevel.classList.contains('level')) {
                this.levelElement.classList.remove('active');
                nextLevel.classList.add('active');
                new WordGame(nextLevel);
            } else {
                document.getElementById('results').style.display = 'block';
                document.querySelector('.action-buttons').style.display = 'flex';
                GameController.showFinalResults();
            }
        }, 1500);
    }
}

class GameController {
    static totalScore = 0;

    static init() {
        document.addEventListener('DOMContentLoaded', () => {
            const firstLevel = document.querySelector('.level.active');
            if (firstLevel) {
                new WordGame(firstLevel);
            }

            document.querySelector('.restart-btn')?.addEventListener('click', () => location.reload());
            document.querySelector('.home-btn')?.addEventListener('click', () => window.location.href = '/');
        });
    }

    static showFinalResults() {
        const finalScoreElement = document.getElementById('final-score');
        if (finalScoreElement) {
            finalScoreElement.textContent = this.totalScore;
        }
    }
}

// Initialize the game
GameController.init();