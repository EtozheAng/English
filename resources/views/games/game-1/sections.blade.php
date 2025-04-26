@extends('layouts.home')

@section('title', 'Игры для детей')

@section('content')
    <style>
        .game-container {
            max-width: 800px;
            margin: 2rem auto;
            padding: 2rem;
            text-align: center;
            background-color: #f8fafc;
            border-radius: 15px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .section-select {
            margin: 2rem 0;
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

        .section-desc {
            color: #64748b;
            font-size: 0.9rem;
        }
    </style>
    <div class="game-container">
        <h1 class="text-3xl font-bold mb-6">Выбери раздел</h1>

        <div class="section-grid">
            @foreach ($categories as $key => $category)
                <a href="{{ route('games.imageCard', ['section' => $key]) }}" class="section-card">
                    <div class="section-icon">{{ $category['icon'] }}</div>
                    <h3 class="section-title">{{ $category['title'] }}</h3>
                    <p class="section-desc">{{ $category['description'] }}</p>
                </a>
            @endforeach
        </div>
    </div>
@endsection
