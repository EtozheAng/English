<?php

namespace App\Http\Controllers;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;

class GameController extends Controller
{
    public function index()
    {
        return view('games.index');
    }
    // game 1
    public function gameOneSections()
    {
        $gameData = $this->getGameData();
        $categories = array_map(function($section) {
            return [
                'icon' => $section['icon'],
                'title' => $section['title'],
                'description' => $section['description']
            ];
        }, $gameData);
    
        return view('games.game-1.sections', [
            'categories' => $categories
        ]);
    }
    public function gameOneImageCard($section = null)
    {
        $categories = $this->getGameData();

        // Если раздел не указан или не существует - перенаправляем
        if (!$section || !array_key_exists($section, $categories)) {
            return redirect()->route('games.create-words-section');
        }

        $selectedCategory = $categories[$section];

        // Перемешиваем слова для каждого уровня
        foreach ($selectedCategory['items'] as &$item) {
            shuffle($item['words']);
        }

        return view('games.game-1.image-card', [
            'levels' => $selectedCategory['items'],
            'section' => $section,
            'sectionTitle' => $selectedCategory['title'],
        ]);
    }
    private function getGameData() {
        $categories = [
            'fruits' => [
                'icon' => '🍎',
                'title' => ' Фрукты и ягоды',
                'description' => 'Учим названия фруктов',
                'items' => [
                    [
                        'image' => 'images/fruits/apple.jpg',
                        'correct_word' => 'Apple',
                        'words' => ['Apple', 'Banana', 'Orange', 'Pear']
                    ],
                    [
                        'image' => 'images/fruits/banana.jpg',
                        'correct_word' => 'Banana',
                        'words' => ['Banana', 'Apple', 'Grapes', 'Pineapple'],
                        
                    ],
                    [
                        'image' => 'images/fruits/orange.webp',
                        'correct_word' => 'Orange',
                       
                        'words' => ['Orange', 'Lemon', 'Kiwi', 'Mango']
                    ],
                    [
                        'image' => 'images/fruits/strawberry.webp',
                        'correct_word' => 'Strawberry',
                       
                        'words' => ['Strawberry', 'Raspberry', 'Blueberry', 'Blackberry']
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
                        'correct_word' => 'Dog',
                        'words' => ['Dog', 'Cat', 'Lion', 'Hamster']
                    ],
                    [
                        'image' => 'images/animals/lion.webp',
                        'correct_word' => 'Lion',
                        'words' => ['Lion', 'Tiger', 'Elephant', 'Giraffe']
                    ],
                    [
                        'image' => 'images/animals/cat.jpg',
                        'correct_word' => 'Cat',
                        'words' => ['Cat', 'Dog', 'Rabbit', 'Fox']
                    ],
                    [
                        'image' => 'images/animals/hamster.jpg',
                        'correct_word' => 'Hamster',
                        'words' => ['Hamster', 'Guinea Pig', 'Mouse', 'Rat']
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
                        'correct_word' => 'Car',
                        'words' => ['Car', 'Bus', 'Truck', 'Bicycle']
                    ],
                    [
                        'image' => 'images/vehicles/bus.jpg',
                        'correct_word' => 'Bus',
                        'words' => ['Bus', 'Train', 'Tram', 'Metro']
                    ],
                    [
                        'image' => 'images/vehicles/airplane.jpg',
                        'correct_word' => 'Airplane',
                        'words' => ['Airplane', 'Helicopter', 'Rocket', 'Balloon']
                    ]
                ]
            ]
        ];
        return $categories;
    }
    //game 2
    public function connectWords()
    {
        $levels = $this->prepareLevels();
        
        return view('games.game-2.connect-words', [
            'levels' => $levels,
            'totalLevels' => count($levels)
        ]);
    }

    private function prepareLevels()
    {
        $allWords = $this->wordsData();
        $levels = [];
        
        // Создаем уровни на основе подготовленных данных
        foreach ($allWords as $levelNumber => $levelWords) {
            // Перемешиваем слова внутри уровня
            shuffle($levelWords);
            
            $levels[] = [
                'englishWords' => array_column($levelWords, 'english'),
                'russianWords' => array_column($levelWords, 'russian'),
                'correctPairs' => array_combine(
                    array_column($levelWords, 'english'),
                    array_column($levelWords, 'russian')
                )
            ];
        }
        
        return $levels;
    }

    private function wordsData()
    {
        return [
            // Уровень 1 - самые простые слова (5 слов)
            1 => [
                ['english' => 'apple', 'russian' => 'яблоко'],
                ['english' => 'dog', 'russian' => 'собака'],
                ['english' => 'house', 'russian' => 'дом'],
                ['english' => 'cat', 'russian' => 'кот'],
                ['english' => 'sun', 'russian' => 'солнце']
            ],
            // Уровень 2 - простые слова (5 новых слов)
            2 => [
                ['english' => 'book', 'russian' => 'книга'],
                ['english' => 'tree', 'russian' => 'дерево'],
                ['english' => 'water', 'russian' => 'вода'],
                ['english' => 'car', 'russian' => 'машина'],
                ['english' => 'pen', 'russian' => 'ручка']
            ],
            // Уровень 3 - средняя сложность
            3 => [
                ['english' => 'school', 'russian' => 'школа'],
                ['english' => 'friend', 'russian' => 'друг'],
                ['english' => 'family', 'russian' => 'семья'],
                ['english' => 'city', 'russian' => 'город'],
                ['english' => 'flower', 'russian' => 'цветок']
            ],
            // Уровень 4 - более сложные
            4 => [
                ['english' => 'computer', 'russian' => 'компьютер'],
                ['english' => 'weather', 'russian' => 'погода'],
                ['english' => 'garden', 'russian' => 'сад'],
                ['english' => 'language', 'russian' => 'язык'],
                ['english' => 'country', 'russian' => 'страна']
            ],
            // Уровень 5 - самые сложные
            5 => [
                ['english' => 'knowledge', 'russian' => 'знание'],
                ['english' => 'happiness', 'russian' => 'счастье'],
                ['english' => 'adventure', 'russian' => 'приключение'],
                ['english' => 'education', 'russian' => 'образование'],
                ['english' => 'universe', 'russian' => 'вселенная']
            ]
        ];
    }

    // game 3
    public function createWordsSections () {
        $gameData = $this->getGameData();
        $categories = array_map(function($section) {
            return [
                'icon' => $section['icon'],
                'title' => $section['title'],
                'description' => $section['description']
            ];
        }, $gameData);
    
        return view('games.game-3.sections', [
            'categories' => $categories
        ]);
    }

    public function createWords($section = null)
    {
        $categories = $this->getGameData();

        // Если раздел не указан или не существует - перенаправляем
        if (!$section || !array_key_exists($section, $categories)) {
            return redirect()->route('games.create-words-section');
        }

        $selectedCategory = $categories[$section];

        // Перемешиваем слова для каждого уровня
        foreach ($selectedCategory['items'] as &$item) {
            $item['separate'] = str_split($item['correct_word']);
            shuffle($item['separate']);
        }

        return view('games.game-3.create-words', [
            'levels' => $selectedCategory['items'],
            'section' => $section,
            'sectionTitle' => $selectedCategory['title'],
        ]);
    }

    //game 4
    public function gameFourSections()
    {
        $gameData = $this->getGameData();
        $categories = array_map(function($section) {
            return [
                'icon' => $section['icon'],
                'title' => $section['title'],
                'description' => $section['description']
            ];
        }, $gameData);
    
        return view('games.game-4.sections', [
            'categories' => $categories
        ]);
    }
    public function gameFourCard(Request $request, $section = null)
    {
        $categories = $this->getGameData();

        // Если раздел не указан или не существует - перенаправляем
        if (!$section || !array_key_exists($section, $categories)) {
            return redirect()->route('games.sections');
        }

        $selectedCategory = $categories[$section];

        foreach($selectedCategory['items'] as &$item) {
            
            // Преобразуем correct_word в массив букв
            $letters = str_split($item['correct_word']);

            // Выбираем случайную букву (кроме первой)
            $randomIndex = rand(1, count($letters) - 1);
            $missingLetter = $letters[$randomIndex];

            // Заменяем выбранную букву на '_'
            $letters[$randomIndex] = '_';
            $wordWithMissing = implode('', $letters);

            // Добавляем новые поля в массив
            $item['word'] = $wordWithMissing;
            $item['missing'] = strtolower($missingLetter);
        }

        return view('games.game-4.missing-letter', [
            'levels' => $selectedCategory['items'],
            'section' => $section,
            'sectionTitle' => $selectedCategory['title'],
        ]);

    }

}