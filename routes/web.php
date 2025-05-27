<?php

use App\Http\Controllers\Dictionary;
use App\Http\Controllers\GameController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;



// Главная страница
Route::get('/', function () {
    return view('index');
})->name('home');

// Страница "О нас"
Route::get('/about', function () {
    return view('about'); // Создайте Blade-шаблон 'about.blade.php'
})->name('about');

// Страница "Курсы"
Route::get('/alphabet', function () {
    return view('alphabet.index'); // Создайте Blade-шаблон 'courses.blade.php'
})->name('alphabet');


Route::get('/dictionary', [Dictionary::class, 'index'])->name('dictionary');



// Страницы Игр
Route::get('/games', [GameController::class, 'index'])->name('games');
Route::get('games/image-card/', [GameController::class, 'gameOneSections'])->name('games.image-card-section');
Route::get('games/image-card/{section?}', [GameController::class, 'gameOneImageCard'])->name('games.image-card');

Route::get('games/connect-words/', [GameController::class, 'connectWords'])->name('games.connect-words');

Route::get('games/create-words/', [GameController::class, 'createWordsSections'])->name('games.create-words-section');
Route::get('games/create-words/{section?}', [GameController::class, 'createWords'])->name('games.create-words');

Route::get('games/missing-letter-game/', [GameController::class, 'gameFourSections'])->name('games.missing-letter-game-section');
Route::get('games/missing-letter-game/{section?}', [GameController::class, 'gameFourCard'])->name('games.missing-letter-game');




Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
