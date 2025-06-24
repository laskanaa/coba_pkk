import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
    server: {
        host: '127.0.0.1', // <--- PENTING: paksa IPv4
        port: 5174,         // <--- Ganti port agar tidak bentrok
        cors: true,
    },
});
