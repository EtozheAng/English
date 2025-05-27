@extends('layouts.home')

@section('title', 'Английский алфавит для детей')

@section('content')
    <div class="alphabet-page">
        <h1 class="page-title">Весёлый английский алфавит</h1>

        <div class="alphabet-container">
            <div class="alphabet-container">
                @foreach (range('A', 'Z') as $letter)
                    <div class="letter-card" onclick="playSound('{{ strtolower($letter) }}')">
                        <div class="letter">{{ $letter }}</div>
                    </div>
                @endforeach
            </div>
        </div>
        <!-- Скрытый аудио элемент -->
        <audio id="audioPlayer"></audio>

        <div class="alphabet-footer">
            <h2>Как учить алфавит?</h2>
            <ul class="tips-list">
                <li>🔤 Пойте песенку ABC каждый день</li>
                <li>🎨 Раскрашивайте буквы разными цветами</li>
                <li>🧩 Играйте в буквенные пазлы и игры</li>
            </ul>
        </div>
    </div>
@endsection

<script>
    function playSound(letter) {
        const audio = document.getElementById('audioPlayer');
        audio.src = `/audio/${letter}.mp3`; // Путь к файлу
        audio.play().catch(e => console.error("Ошибка воспроизведения:", e));
    }
</script>

<style>
    .alphabet-page {
        max-width: 900px;
        margin: 0 auto;
        padding: 20px;
        font-family: 'Comic Sans MS', cursive, sans-serif;
        text-align: center;
        background-color: #f0f9ff;
    }

    .page-title {
        color: #ff6b6b;
        font-size: 2.5rem;
        margin-bottom: 30px;
        text-shadow: 2px 2px 0px #fff;
    }

    .alphabet-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(80px, 1fr));
        gap: 15px;
        margin-bottom: 40px;
    }

    .letter-card {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, #74ebd5, #ACB6E5);
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        cursor: pointer;
        border: 3px solid #fff;
    }

    .letter-card:hover {
        transform: scale(1.1) rotate(5deg);
        box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
        background: linear-gradient(135deg, #ffc3a0, #ffafbd);
    }

    .letter {
        font-size: 3rem;
        font-weight: bold;
        color: white;
        text-shadow: 2px 2px 0px rgba(0, 0, 0, 0.2);
    }

    .alphabet-footer {
        background-color: white;
        padding: 20px;
        border-radius: 20px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .alphabet-footer h2 {
        color: #5f6caf;
        font-size: 1.8rem;
        margin-bottom: 15px;
    }

    .tips-list {
        text-align: left;
        font-size: 1.2rem;
        color: #555;
        line-height: 1.6;
        padding-left: 20px;
    }

    .tips-list li {
        margin-bottom: 10px;
    }

    @media (max-width: 600px) {
        .alphabet-container {
            grid-template-columns: repeat(auto-fit, minmax(60px, 1fr));
        }

        .letter-card {
            width: 60px;
            height: 60px;
        }

        .letter {
            font-size: 2.2rem;
        }
    }
</style>
