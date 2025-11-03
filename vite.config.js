import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        tailwindcss(),
    ],
    server: {
        host: true,
        port: 5173,
        cors: {
            origin: ['http://localhost:8080', 'http://127.0.0.1:8080'],
            methods: ['GET', 'HEAD', 'OPTIONS'],
            allowedHeaders: ['*'],
        },
        hmr: {
            host: '127.0.0.1',
            clientPort: 5173,
        },
        origin: 'http://localhost:5173',
    },
});
