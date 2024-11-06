import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/app-admin.css',
                'resources/css/app-admin-login.css',
                'resources/css/theme-admin.css',
                'resources/js/app.js',
                'resources/js/app-admin.js',
                'resources/js/theme-admin.js',
            ],
            refresh: true,
        }),
    ],
});
