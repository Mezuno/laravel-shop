import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import path from 'path'

export default defineConfig({
    plugins: [
        vue(),
        laravel({
            input: ['resources/css/app.scss', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
    resolve: {
        alias:{
            '@/': path.join(__dirname, '/resources/js/'),
            '~': path.join(__dirname, '/node_modules/'),
        },
    },
});
