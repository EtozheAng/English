<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Главная страница</title>
    @vite('resources/js/app.js') <!-- Вставляем скомпилированные скрипты и стили через Vite -->
</head>

<body>

    @include('include.header')

    <div class="main-content">
        @yield('content')
    </div>

    @include('include.footer')

    <script src="{{ mix('js/app.js') }}"></script>
</body>

</html>
