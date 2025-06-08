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
                        'sound' => 'sounds/fruits/apple.mp3',
                        'en' => 'Apple',
                        'ru' => 'Яблоко',
                    ],
                    [
                        'image' => 'images/fruits/banana.jpg',
                        'sound' => 'sounds/fruits/banana.mp3',
                        'en' => 'Banana',
                        'ru' => 'Банан',
                    ],
                    [
                        'image' => 'images/fruits/orange.webp',
                        'sound' => 'sounds/fruits/orange.mp3',
                        'en' => 'Orange',
                        'ru' => 'Апельсин',
                    ],
                    [
                        'image' => 'images/fruits/strawberry.webp',
                        'sound' => 'sounds/fruits/strawberry.mp3',
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
                        'sound' => 'sounds/animals/dog.mp3',
                        'en' => 'Dog',
                        'ru' => 'Собака',
                    ],
                    [
                        'image' => 'images/animals/lion.webp',
                        'sound' => 'sounds/animals/lion.mp3',
                        'en' => 'Lion',
                        'ru' => 'Лев',
                    ],
                    [
                        'image' => 'images/animals/cat.jpg',
                        'sound' => 'sounds/animals/cat.mp3',
                        'en' => 'Cat',
                        'ru' => 'Кот',
                    ],
                    [
                        'image' => 'images/animals/hamster.jpg',
                        'sound' => 'sounds/animals/hamster.mp3',
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
                        'sound' => 'sounds/vehicles/car.mp3',
                        'en' => 'Car',
                        'ru' => 'Машина'
                    ],
                    [
                        'image' => 'images/vehicles/bus.jpg',
                        'sound' => 'sounds/vehicles/bus.mp3',
                        'en' => 'Bus',
                        'ru' => 'Автобус'
                    ],
                    [
                        'image' => 'images/vehicles/airplane.jpg',
                        'sound' => 'sounds/vehicles/airplane.mp3',
                        'en' => 'Airplane',
                        'ru' => 'Самолет'
                    ],
                    [
                        'image' => 'images/vehicles/truck.webp',
                        'sound' => 'sounds/vehicles/truck.mp3',
                        'en' => 'Truck',
                        'ru' => 'Грузовик',
                    ]
                ]
            ]
        ];
        return $categories;
    }
}
