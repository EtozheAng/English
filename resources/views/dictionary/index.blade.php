@extends('layouts.home')

@section('title', 'Англо-русский словарь')

@section('content')
    <div class="container dictionary-page">
        <h1 class="page-title">Англо-русский словарь</h1>

        <div class="section-grid">
            @foreach ($words as $key => $category)
                <button class="section-card letter-filter" data-letter="{{ $key }}">
                    <div class="section-icon">{{ $category['icon'] }}</div>
                    <h3 class="section-title">{{ $category['title'] }}</h3>
                    <p>{{ $key }}</p>
                </button>
            @endforeach
        </div>

        <div class="dictionary-container">
            @foreach ($words as $letter => $letterWords)
                <div class="letter-section" id="letter-{{ $letter }}">
                    <h2 class="letter-title">{{ $letter }}</h2>
                    <div class="words-list">
                        @foreach ($letterWords['items'] as $item)
                            <div class="word-card">
                                <div class="word-en">{{ $item['en'] }}</div>
                                <div class="word-ru">{{ $item['ru'] }}</div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('.letter-filter').forEach(btn => {
            btn.addEventListener('click', () => {
                const letter = btn.dataset.letter;
                document.querySelectorAll('.letter-section').forEach(section => {
                    section.style.display = section.id === `letter-${letter}` ?
                        'block' : 'none';
                });
            });
        });
    })
</script>

<style>
    /* Общие стили как в алфавите */
    .dictionary-page {
        max-width: 900px;
        margin: 0 auto;
        padding: 20px;
        font-family: 'Comic Sans MS', cursive, sans-serif;
    }

    .page-title {
        color: #ff6b6b;
        text-align: center;
        margin-bottom: 30px;
    }

    .alphabet-filter {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 10px;
        margin-bottom: 20px;
    }

    /* .letter-filter {
        width: 40px;
        height: 40px;
        border: none;
        border-radius: 50%;
        background: #74ebd5;
        color: white;
        font-weight: bold;
        cursor: pointer;
        transition: all 0.3s;
    }

    .letter-filter:hover {
        background: #ACB6E5;
        transform: scale(1.1);
    } */

    .letter-section {
        margin-bottom: 30px;
        display: none;
        /* Сначала скрываем все разделы */
    }

    .letter-section:first-child {
        display: block;
        /* Показываем первую букву по умолчанию */
    }

    .letter-title {
        color: #5f6caf;
        font-size: 2rem;
        border-bottom: 2px solid #74ebd5;
        padding-bottom: 5px;
    }

    .words-list {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 15px;
        margin-top: 15px;
    }

    .word-card {
        background: white;
        border-radius: 10px;
        padding: 15px;
        box-shadow: 0 3px 6px rgba(0, 0, 0, 0.1);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .word-en {
        font-weight: bold;
        color: #2c3e50;
    }

    .word-ru {
        color: #7f8c8d;
    }

    .play-btn {
        background: #ff6b6b;
        color: white;
        border: none;
        width: 30px;
        height: 30px;
        border-radius: 50%;
        cursor: pointer;
        transition: all 0.3s;
    }

    .play-btn:hover {
        background: #ff8e8e;
        transform: scale(1.1);
    }

    .section-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.5rem;
        margin-top: 2rem;
    }

    .section-card {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        transition: all 0.3s ease;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        text-decoration: none;
        color: inherit;
    }

    .section-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
    }

    .section-icon {
        font-size: 3rem;
        margin-bottom: 1rem;
    }

    .section-title {
        font-size: 1.25rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }
</style>
