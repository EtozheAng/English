<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Dictionary extends Controller
{
    public function index()
    {
        $words = $this->gatGameData();
        return view('dictionary.index', compact('words'));
    }
    private function gatGameData() {
        $categories = [
            'fruits' => [
                'icon' => '🍎',
                'title' => ' Фрукты и ягоды',
                'description' => 'Учим названия фруктов',
                'items' => [
                    [
                        'image' => 'images/fruits/apple.jpg',
                        'en' => 'Apple',
                        'ru' => 'Яблоко',
                    ],
                    [
                        'image' => 'images/fruits/banana.jpg',
                        'en' => 'Banana',
                        'ru' => 'Банан',
                    ],
                    [
                        'image' => 'images/fruits/orange.webp',
                        'en' => 'Orange',
                        'ru' => 'Апельсин',
                    ],
                    [
                        'image' => 'images/fruits/strawberry.webp',
                        'en' => 'Strawberry',
                        'ru' => 'Клубника',
                    ]
                ]
            ],
            'animals' => [
                'icon' => '🐶',
                'title' => 'Животные',
                'description' => 'Знакомимся с животными',
                'items' => [
                    [
                        'image' => 'images/animals/dog.jpeg',
                        'en' => 'Dog',
                        'ru' => 'Собака',
                    ],
                    [
                        'image' => 'images/animals/lion.webp',
                        'en' => 'Lion',
                        'ru' => 'Лев',
                    ],
                    [
                        'image' => 'images/animals/cat.jpg',
                        'en' => 'Cat',
                        'ru' => 'Кот',
                    ],
                    [
                        'image' => 'images/animals/hamster.jpg',
                        'en' => 'Hamster',
                        'ru' => 'Хомяк',
                    ]
                ]
            ],
            'vehicles' => [
                'icon' => '🚗',
                'title' => 'Транспорт',
                'description' => 'Изучаем транспорт',
                'items' => [
                    [
                        'image' => 'images/vehicles/car.jpg',
                        'en' => 'Car',
                        'ru' => 'Машина'
                    ],
                    [
                        'image' => 'images/vehicles/bus.jpg',
                        'en' => 'Bus',
                        'ru' => 'Автобус'
                    ],
                    [
                        'image' => 'images/vehicles/airplane.jpg',
                        'en' => 'Airplane',
                        'ru' => 'Самолет'
                        ]
                ]
            ]
        ];
        return $categories;
    }
}
