import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import path from 'path';

export default defineConfig({
    server: {
        host: '0.0.0.0', // Escucha en todas las interfaces
        port: 5173,
        hmr: {
            host: 'localhost' // o la IP de tu host
        }
    },
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js'
            ],
            refresh: true,
        }),
    ],
    resolve: {
        alias: {
            '~tailwindcss': path.resolve(__dirname, 'node_modules/tailwindcss'),
        }
    }
});