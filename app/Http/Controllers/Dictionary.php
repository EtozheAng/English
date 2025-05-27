<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Dictionary extends Controller
{
    public function index()
    {
        $words = $this->gatGameData();
        // $words = [
        //     'A' => [
        //         'Apple' => 'яблоко', 
        //         'Ant' => 'муравей',
        //         'Airplane' => 'самолет'
        //     ],
        //     'B' => [
        //         'Ball' => 'мяч', 
        //         'Book' => 'книга',
        //         'Baby' => 'ребенок'
        //     ],
        //     'C' => [
        //         'Cat' => 'кошка',
        //         'Car' => 'машина',
        //         'Cloud' => 'облако'
        //     ],
        //     'D' => [
        //         'Dog' => 'собака',
        //         'Door' => 'дверь',
        //         'Dolphin' => 'дельфин'
        //     ],
        //     'E' => [
        //         'Elephant' => 'слон',
        //         'Egg' => 'яйцо',
        //         'Ear' => 'ухо'
        //     ],
        //     'F' => [
        //         'Fish' => 'рыба',
        //         'Flower' => 'цветок',
        //         'Fox' => 'лиса'
        //     ],
        //     'G' => [
        //         'Girl' => 'девочка',
        //         'Giraffe' => 'жираф',
        //         'Grass' => 'трава'
        //     ],
        //     'H' => [
        //         'House' => 'дом',
        //         'Hat' => 'шляпа',
        //         'Horse' => 'лошадь'
        //     ],
        //     'I' => [
        //         'Ice' => 'лед',
        //         'Island' => 'остров',
        //         'Igloo' => 'иглу'
        //     ],
        //     'J' => [
        //         'Juice' => 'сок',
        //         'Jacket' => 'куртка',
        //         'Jellyfish' => 'медуза'
        //     ],
        //     'K' => [
        //         'Kite' => 'воздушный змей',
        //         'Kangaroo' => 'кенгуру',
        //         'Key' => 'ключ'
        //     ],
        //     'L' => [
        //         'Lion' => 'лев',
        //         'Leaf' => 'лист',
        //         'Lamp' => 'лампа'
        //     ],
        //     'M' => [
        //         'Monkey' => 'обезьяна',
        //         'Moon' => 'луна',
        //         'Milk' => 'молоко'
        //     ],
        //     'N' => [
        //         'Nose' => 'нос',
        //         'Nest' => 'гнездо',
        //         'Night' => 'ночь'
        //     ],
        //     'O' => [
        //         'Orange' => 'апельсин',
        //         'Owl' => 'сова',
        //         'Ocean' => 'океан'
        //     ],
        //     'P' => [
        //         'Panda' => 'панда',
        //         'Pizza' => 'пицца',
        //         'Pencil' => 'карандаш'
        //     ],
        //     'Q' => [
        //         'Queen' => 'королева',
        //         'Quilt' => 'лоскутное одеяло',
        //         'Question' => 'вопрос'
        //     ],
        //     'R' => [
        //         'Rabbit' => 'кролик',
        //         'Rainbow' => 'радуга',
        //         'Robot' => 'робот'
        //     ],
        //     'S' => [
        //         'Sun' => 'солнце',
        //         'Star' => 'звезда',
        //         'Snow' => 'снег'
        //     ],
        //     'T' => [
        //         'Tree' => 'дерево',
        //         'Tiger' => 'тигр',
        //         'Table' => 'стол'
        //     ],
        //     'U' => [
        //         'Umbrella' => 'зонт',
        //         'Unicorn' => 'единорог',
        //         'Uniform' => 'форма'
        //     ],
        //     'V' => [
        //         'Violin' => 'скрипка',
        //         'Vegetables' => 'овощи',
        //         'Volcano' => 'вулкан'
        //     ],
        //     'W' => [
        //         'Water' => 'вода',
        //         'Whale' => 'кит',
        //         'Window' => 'окно'
        //     ],
        //     'X' => [
        //         'Xylophone' => 'ксилофон',
        //         'X-ray' => 'рентген',
        //         'Xenopus' => 'шпорцевая лягушка'
        //     ],
        //     'Y' => [
        //         'Yak' => 'як',
        //         'Yacht' => 'яхта',
        //         'Yogurt' => 'йогурт'
        //     ],
        //     'Z' => [
        //         'Zoo' => 'зоопарк',
        //         'Zebra' => 'зебра',
        //         'Zipper' => 'молния'
        //     ]
        // ];
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
