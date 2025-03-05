import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import path from 'path';
import tailwindcss from '@tailwindcss/vite'

export default defineConfig({
    plugins: [
        // tailwindcss(),
        laravel({
            input: ['resources/css/app.css','resources/scss/__variable.scss','resources/scss/app.scss', 'resources/js/app.js'],
            refresh: true,
        }),
        vue(),
    ],
     resolve: {
        alias: {
            'vue': 'vue/dist/vue.esm-bundler.js',
            'ui': path.resolve(__dirname, 'resources/scss/__variable.scss'),
            '@': path.resolve(__dirname, 'resources/vue'),
        },
    },
});
