import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    server: {
        host: 'school-dunaeva.ru', // Укажите ваш домен
        port: 5173, // Порт, который использует Vite
        hmr: {
            host: 'school-dunaeva.ru', // Укажите ваш домен для HMR
        },
        cors: true, // Разрешить CORS
    },
    plugins: [
        laravel({
            input: [
                'resources/sass/app.scss',
                'resources/js/app.js',
                'resources/js/base-game.js',
                'resources/js/audio-quiz.js',
                'resources/js/image-card-game.js',
                'resources/js/missing-letter-game.js',
                'resources/js/word-game.js',
                'resources/js/word-matching-game.js',
            ],
            refresh: true,
        }),
    ],
});
