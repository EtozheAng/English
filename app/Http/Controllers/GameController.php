<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GameController extends Controller
{
    public function index()
    {
        return view('games.index');  // Шаблон для страницы с играми
    }
    // Метод для игры "Карточка с изображением"
    public function imageCard()
    {
        // Данные для игры
        $levels = [
            // Раздел 1: Фрукты
            // [
            //     'image' => 'images/fruits/apple.jpg', // Путь к изображению яблока
            //     'correct_word' => 'Apple', // Правильное слово
            //     'words' => ['Apple', 'Banana', 'Orange', 'Pear'], // Варианты слов
            // ],
            // [
            //     'image' => 'images/fruits/banana.jpg',
            //     'correct_word' => 'Banana',
            //     'words' => ['Banana', 'Apple', 'Grapes', 'Pineapple'],
            // ],
            // [
            //     'image' => 'images/fruits/orange.webp',
            //     'correct_word' => 'Orange',
            //     'words' => ['Orange', 'Lemon', 'Kiwi', 'Mango'],
            // ],
        
            // Раздел 2: Животные
            [
                'image' => 'images/animals/dog.jpeg',
                'correct_word' => 'Dog',
                'words' => ['Dog', 'Cat', 'Lion', 'Hamster'],
            ],
            [
                'image' => 'images/animals/lion.webp',
                'correct_word' => 'Lion',
                'words' => ['Dog', 'Cat', 'Lion', 'Hamster'],
            ],
            [
                'image' => 'images/animals/cat.jpg',
                'correct_word' => 'Cat',
                'words' => ['Dog', 'Cat', 'Lion', 'Hamster'],
            ],
            [
                'image' => 'images/animals/hamster.jpg',
                'correct_word' => 'Hamster',
                'words' => ['Dog', 'Cat', 'Lion', 'Hamster'],
            ],
        
        ];

           // Перемешиваем слова для каждого уровня
        foreach ($levels as &$level) {
            shuffle($level['words']);
        }

        // Передача данных в шаблон
        return view('games.image-card', ['levels' => $levels]);
    }
}




// $levels = [
    // Раздел 1: Фрукты
    // [
    //     'image' => 'images/fruits/apple.jpg', // Путь к изображению яблока
    //     'correct_word' => 'Apple', // Правильное слово
    //     'words' => ['Apple', 'Banana', 'Orange', 'Pear'], // Варианты слов
    // ],
    // [
    //     'image' => 'images/fruits/banana.jpg',
    //     'correct_word' => 'Banana',
    //     'words' => ['Banana', 'Apple', 'Grapes', 'Pineapple'],
    // ],
    // [
    //     'image' => 'images/fruits/orange.webp',
    //     'correct_word' => 'Orange',
    //     'words' => ['Orange', 'Lemon', 'Kiwi', 'Mango'],
    // ],

    // Раздел 2: Животные
    // [
    //     'image' => 'images/animals/dog.jpeg',
    //     'correct_word' => 'Dog',
    //     'words' => ['Dog', 'Cat', 'Lion', 'Hamster'],
    // ],
    // [
    //     'image' => 'images/animals/lion.webp',
    //     'correct_word' => 'Lion',
    //     'words' => ['Dog', 'Cat', 'Lion', 'Hamster'],
    // ],
    // [
    //     'image' => 'images/animals/cat.jpg',
    //     'correct_word' => 'Cat',
    //     'words' => ['Dog', 'Cat', 'Lion', 'Hamster'],
    // ],
    // [
    //     'image' => 'images/animals/hamster.jpg',
    //     'correct_word' => 'Hamster',
    //     'words' => ['Dog', 'Cat', 'Lion', 'Hamster'],
    // ],

//     // Раздел 3: Транспорт
//     [
//         'image' => 'images/transport/car.jpg',
//         'correct_word' => 'Car',
//         'words' => ['Car', 'Bus', 'Bicycle', 'Motorcycle'],
//     ],
//     [
//         'image' => 'images/transport/airplane.jpg',
//         'correct_word' => 'Airplane',
//         'words' => ['Airplane', 'Helicopter', 'Rocket', 'Ship'],
//     ],
//     [
//         'image' => 'images/transport/train.jpg',
//         'correct_word' => 'Train',
//         'words' => ['Train', 'Tram', 'Subway', 'Truck'],
//     ],

//     // Раздел 4: Спорт
//     [
//         'image' => 'images/sports/football.jpg',
//         'correct_word' => 'Football',
//         'words' => ['Football', 'Basketball', 'Tennis', 'Volleyball'],
//     ],
//     [
//         'image' => 'images/sports/basketball.jpg',
//         'correct_word' => 'Basketball',
//         'words' => ['Basketball', 'Soccer', 'Hockey', 'Rugby'],
//     ],
//     [
//         'image' => 'images/sports/tennis.jpg',
//         'correct_word' => 'Tennis',
//         'words' => ['Tennis', 'Badminton', 'Table Tennis', 'Golf'],
//     ],

//     // Раздел 5: Профессии
//     [
//         'image' => 'images/professions/doctor.jpg',
//         'correct_word' => 'Doctor',
//         'words' => ['Doctor', 'Teacher', 'Engineer', 'Artist'],
//     ],
//     [
//         'image' => 'images/professions/chef.jpg',
//         'correct_word' => 'Chef',
//         'words' => ['Chef', 'Waiter', 'Baker', 'Barista'],
//     ],
//     [
//         'image' => 'images/professions/police.jpg',
//         'correct_word' => 'Police',
//         'words' => ['Police', 'Firefighter', 'Soldier', 'Pilot'],
//     ],
// ];