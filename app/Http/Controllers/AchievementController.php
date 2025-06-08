<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AchievementController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        $games = [
            [
                'name' => "Угадай слово по картинке",
                'slug' => "image-card",
                'icon' => "🖼️",
                'color' => "from-green-300 to-teal-300"
            ],
            [
                'name' => "Собери слово из букв",
                'slug' => "word_game",
                'icon' => "🧩",
                'color' => "from-pink-300 to-purple-300"
            ],
            [
                'name' => "Встать пропущенную букву",
                'slug' => "missing_letter",
                'icon' => "🆎",
                'color' => "from-blue-300 to-cyan-300"
            ],
            [
                'name' => "Угадай слово на слух",
                'slug' => "audio-quiz",
                'icon' => "🎧",
                'color' => "from-green-300 to-teal-300"
            ],

        ];

        // Получаем результаты для всех игр с учетом разделов
        $results = collect($games)->map(function($game) use ($user) {
            // Сумма очков из всех разделов для данной игры
            $game['totalScore'] = $user->gameResults()
                ->where('game_type', $game['slug'])
                ->sum('score') ?? 0;
                
            // Лучшие результаты по разделам для данной игры
            $game['sections'] = $user->gameResults()
                ->where('game_type', $game['slug'])
                ->selectRaw('section, MAX(score) as best_score')
                ->groupBy('section')
                ->get()
                ->mapWithKeys(function($item) {
                    return [$item->section => $item->best_score];
                });
                
            return $game;
        });

        $totalScore = $results->sum('totalScore');
        $progressPercent = min(100, ($totalScore / 480) * 100);

        return view('dashboard', compact('results', 'totalScore', 'progressPercent'));
    }
}