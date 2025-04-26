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
            input: ['resources/css/app.css', 'resources/sass/app.scss', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
});
