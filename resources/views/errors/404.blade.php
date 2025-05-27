@extends('layouts.home') {{-- Используйте ваш основной layout --}}

@section('content')
    <div class="error-page">
        <div class="error-content">
            <h1>404</h1>
            <h2>Страница не найдена</h2>
            <p>Запрашиваемая страница не существует или была перемещена.</p>
            <a href="{{ url('/') }}" class="home-btn">На главную</a>
        </div>
    </div>

    <style>
        .error-page {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%;
            text-align: center;
        }

        .error-content {
            padding: 40px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        h1 {
            font-size: 6rem;
            color: #e74c3c;
            margin: 0;
        }

        h2 {
            font-size: 2rem;
            margin-top: 0;
        }

        .home-btn {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background: #3498db;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background 0.3s;
        }

        .home-btn:hover {
            background: #2980b9;
        }
    </style>
@endsection
