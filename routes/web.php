<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GameController;


// Главная страница
Route::get('/', function () {
    return view('index');
})->name('home');

// Страница "О нас"
Route::get('/about', function () {
    return view('about'); // Создайте Blade-шаблон 'about.blade.php'
})->name('about');

// Страница "Курсы"
Route::get('/courses', function () {
    return view('courses'); // Создайте Blade-шаблон 'courses.blade.php'
})->name('courses');



// Страницы Игры
Route::get('/games', [GameController::class, 'index'])->name('games');
Route::get('games/image-card', [GameController::class, 'imageCard'])->name('games.imageCard');



Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
