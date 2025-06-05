<x-app-layout>
    {{-- <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot> --}}

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-3xl font-bold text-purple-600 mb-6">🎉 Твои достижения! 🎉</h1>

                    <!-- Общий счет в виде медали -->
                    <div id="total-scores"
                        class="mt-4 p-6 bg-gradient-to-r from-yellow-200 to-yellow-100 rounded-2xl 
                        border-4 border-yellow-300 shadow-lg transform  transition-transform">
                        <div class="flex items-center justify-center mb-4">
                            <img src="https://cdn-icons-png.flaticon.com/512/3132/3132735.png"
                                class="w-16 h-16 animate-bounce" alt="Медаль">
                            <h2 class="text-2xl font-bold text-center ml-3">
                                Твой общий счёт: <span id="total-score-value" class="text-4xl text-purple-700">0</span>
                                <span class="text-xl">очков</span>
                            </h2>
                        </div>

                        <!-- Прогресс-бар -->
                        <div class="w-full bg-gray-200 rounded-full h-6 mb-6">
                            <div id="progress-bar"
                                class="bg-gradient-to-r from-green-400 to-blue-500 h-6 rounded-full 
                                transition-all duration-1000"
                                style="width: 0%"></div>
                        </div>

                        <!-- Иконки игр с анимацией -->
                        <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-5 game-cards">
                            <!-- Карточка будет добавлена через JS -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Получаем значения из localStorage
        const games = [{
                name: "Сопоставление слов",
                key: "bestScore_word_game",
                icon: "📝",
                color: "from-pink-300 to-purple-300"
            },
            {
                name: "Пропущенные буквы",
                key: "bestScore_missing_letter",
                icon: "🔠",
                color: "from-blue-300 to-cyan-300"
            },
            {
                name: "Карточки с картинками",
                key: "bestScore_image-card",
                icon: "🖼️",
                color: "from-green-300 to-teal-300"
            },
            {
                name: "Соедини слова",
                key: "bestScore_word-matching",
                icon: "📖",
                color: "from-green-300 to-teal-300"
            }
        ];

        // Считаем результаты
        let totalScore = 0;
        const results = games.map(game => {
            const score = parseInt(localStorage.getItem(game.key)) || 0;
            totalScore += score;
            return {
                ...game,
                score
            };
        });

        // Обновляем общий счет
        const totalElement = document.getElementById('total-score-value');
        totalElement.textContent = totalScore;

        // Прогресс-бар (максимум 300 очков)
        const progressBar = document.getElementById('progress-bar');
        const progressPercent = Math.min(100, (totalScore / 300) * 100);
        setTimeout(() => {
            progressBar.style.width = `${progressPercent}%`;
        }, 500);

        // Создаем карточки игр
        const gamesContainer = document.querySelector('.game-cards');
        gamesContainer.innerHTML = results.map(game => `
            <div class="p-4 rounded-xl bg-gradient-to-r ${game.color} shadow-md 
                transform hover:scale-110 transition-all duration-300 animate-fade-in">
                <div class="text-5xl text-center mb-3">${game.icon}</div>
                <h3 class="text-xl font-bold text-center">${game.name}</h3>
                <div class="text-3xl font-bold text-center mt-2">${game.score}</div>
                <div class="text-center mt-1">очков</div>
                
                <!-- Звездочки за достижения -->
                <div class="flex justify-center mt-3">
                    ${Array.from({length: Math.min(5, Math.floor(game.score/8))})
                        .map(() => '⭐').join('')}
                </div>
            </div>
        `).join('');
    });
</script>

<style>
    /* Анимации */
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes bounce {

        0%,
        100% {
            transform: translateY(0);
        }

        50% {
            transform: translateY(-10px);
        }
    }

    .animate-fade-in {
        animation: fadeIn 0.8s ease-out forwards;
    }

    .animate-bounce {
        animation: bounce 2s infinite;
    }

    /* Задержки для последовательного появления */
    .game-cards div:nth-child(1) {
        animation-delay: 0.2s;
    }

    .game-cards div:nth-child(2) {
        animation-delay: 0.4s;
    }

    .game-cards div:nth-child(3) {
        animation-delay: 0.6s;
    }
</style>
