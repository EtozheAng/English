<?php

namespace App\Http\Controllers;

use App\Models\GameResult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ScoreController extends Controller
{
    public function saveScore(Request $request)
    {
        // Валидация входных данных
        $validated = $request->validate([
            'score' => 'required|integer|min:0',
            'game_type' => 'required|string',
            'section' => 'required|string' // Добавляем валидацию для раздела
        ]);
    
        try {          
            $user = $request->user();

            // Проверяем, что пользователь аутентифицирован
            if (!$user) {
                Log::error('User not authenticated!');
                return response()->json([
                    'success' => false,
                    'message' => 'User is not authenticated.',
                ], 401); // Unauthorized
            }
    
            // Сохраняем результат в базу данных с указанием раздела
            $gameResult = GameResult::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'game_type' => $validated['game_type'],
                    'section' => $validated['section'] // Уникальная комбинация пользователь-тип игры-раздел
                ],
                [
                    'score' => $validated['score']
                ]
            );
            
            // Получаем все результаты пользователя для данного типа игры
            $userResults = $user->gameResults()
                ->where('game_type', $validated['game_type'])
                ->get();
            
            // Суммируем очки из всех разделов
            $totalScore = $userResults->sum('score');
            
            // Получаем лучший результат для каждого раздела
            $sectionScores = $userResults->groupBy('section')
                ->map(function ($results) {
                    return $results->max('score');
                });
            
            return response()->json([
                'success' => true,
                'message' => 'Result saved successfully',
                'totalScore' => $totalScore,
                'sectionScores' => $sectionScores,
                'gameResult' => $gameResult // Для отладки
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to save result',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}