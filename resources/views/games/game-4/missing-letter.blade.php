@extends('layouts.home')

@vite(['resources/js/missing-letter-game.js'])

@section('content')
    <div class="missing-letter-game">
        <div class="game-header">
            <h1>Вставь пропущенную букву</h1>
        </div>

        <div class="game-container">
            @foreach ($levels as $index => $level)
                <div class="game-slide level {{ $index === 0 ? 'active' : '' }}">
                    <div class="image-container">
                        <img src="{{ asset($level['image']) }}" alt="{{ $level['correct_word'] }}">
                        <div class="hint">{{ $sectionTitle }}</div>
                    </div>

                    <div class="word-container">
                        @foreach (str_split($level['word']) as $char)
                            @if ($char === '_')
                                <span class="letter missing" data-correct="{{ $level['missing'] }}">_</span>
                            @else
                                <span class="letter">{{ $char }}</span>
                            @endif
                        @endforeach
                    </div>

                    <div class="input-group">
                        <input type="text" class="letter-input" maxlength="1" placeholder="?" autofocus>
                        <button class="check-btn">Проверить</button>
                    </div>

                    <div class="feedback"></div>
                </div>
            @endforeach
        </div>

        <!-- Панель результатов -->
        <div class="results-panel" id="results">
        </div>

        <!-- Кнопки действий -->
        <div class="action-buttons">
            <button class="action-btn restart-btn">Начать заново</button>
            <button class="action-btn home-btn">Вернуться на главную</button>
        </div>
    </div>
@endsection


<style>
    .missing-letter-game {
        max-width: 800px;
        margin: 0 auto;
        padding: 20px;
        font-family: 'Comic Sans MS', cursive;
    }

    .game-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
    }

    .game-header h1 {
        color: #2c3e50;
        font-size: 2.2rem;
        margin: 0;
    }

    .score {
        font-size: 1.5rem;
        font-weight: bold;
        color: #e74c3c;
    }

    .game-container {
        position: relative;
        /* min-height: 400px; */
    }

    .game-slide {
        display: none;
        text-align: center;
        background: #f9f9f9;
        border-radius: 15px;
        padding: 30px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .game-slide.active {
        display: block;
        animation: fadeIn 0.5s;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
        }

        to {
            opacity: 1;
        }
    }

    .image-container {
        margin-bottom: 20px;
    }

    .image-container img {
        max-height: 300px;
        object-fit: contain;
        border-radius: 10px;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.2);
    }

    .hint {
        margin-top: 10px;
        font-style: italic;
        color: #7f8c8d;
    }

    .word-container {
        font-size: 2.5rem;
        letter-spacing: 10px;
        margin: 30px 0;
        font-weight: bold;
    }

    .letter {
        display: inline-block;
        min-width: 30px;
        text-align: center;
    }

    .letter.missing {
        color: #e74c3c;
        text-decoration: underline;
    }

    .input-group {
        display: flex;
        justify-content: center;
        gap: 10px;
        margin: 20px 0;
    }

    .letter-input {
        width: 60px;
        height: 60px;
        font-size: 2rem;
        text-align: center;
        text-transform: uppercase;
        border: 3px solid #3498db;
        border-radius: 10px;
        outline: none;
    }

    .check-btn {
        padding: 0 25px;
        background: #2ecc71;
        color: white;
        border: none;
        border-radius: 10px;
        font-size: 1.2rem;
        cursor: pointer;
        transition: all 0.3s;
    }

    .check-btn:hover {
        background: #27ae60;
        transform: translateY(-2px);
    }

    .feedback {
        min-height: 30px;
        font-size: 1.3rem;
        margin: 15px 0;
        font-weight: bold;
    }

    .feedback.correct {
        color: #27ae60;
    }

    .feedback.incorrect {
        color: #e74c3c;
    }

    .game-controls {
        display: flex;
        justify-content: center;
        gap: 20px;
        margin-top: 30px;
    }

    .game-controls button {
        padding: 12px 25px;
        border: none;
        border-radius: 8px;
        font-size: 1.1rem;
        cursor: pointer;
        transition: all 0.3s;
    }

    .results-panel {
        display: none;
        text-align: center;
        margin: 30px auto;
        padding: 25px;
        background-color: #f8f9fa;
        border-radius: 15px;
        max-width: 500px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        animation: fadeIn 0.5s ease;
    }

    .results-title {
        color: #2c3e50;
        margin-bottom: 15px;
    }

    .score-display {
        font-size: 1.2rem;
        margin: 15px 0;
    }

    .action-buttons {
        display: none;
        justify-content: center;
        gap: 15px;
        margin-top: 30px;
        flex-wrap: wrap;
    }

    .action-btn {
        padding: 12px 25px;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 600;
        transition: all 0.3s ease;
        font-size: 1rem;
    }

    .restart-btn {
        background-color: #3498db;
        color: white;
    }

    .restart-btn:hover {
        background-color: #2980b9;
        transform: translateY(-2px);
    }

    .home-btn {
        background-color: #7f8c8d;
        color: white;
    }

    .home-btn:hover {
        background-color: #6c7a7d;
        transform: translateY(-2px);
    }

    .result-item {
        margin: 15px 0;
        display: flex;
        justify-content: space-between;
        max-width: 300px;
        margin-left: auto;
        margin-right: auto;
    }

    .result-label {
        font-weight: 600;
        color: #555;
    }

    .result-value {
        font-weight: 700;
        color: #2c3e50;
    }

    .completion-message {
        margin-top: 20px;
        font-size: 1.2rem;
        color: #27ae60;
        font-weight: 600;
        padding: 10px;
        background-color: #e8f5e9;
        border-radius: 8px;
    }


    @media (max-width: 600px) {
        .word-container {
            font-size: 1.8rem;
            letter-spacing: 5px;
        }

        .letter-input {
            width: 50px;
            height: 50px;
            font-size: 1.5rem;
        }
    }
</style>
