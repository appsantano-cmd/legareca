// File: vite.config.js
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/public.css',  // Pastikan ini ada
                'resources/js/public.js'     // Pastikan ini ada
            ],
            refresh: true,
        }),
    ],
});