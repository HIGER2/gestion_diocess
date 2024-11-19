import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css','resources/scss/__variable.scss','resources/scss/app.scss', 'resources/js/app.js'],
            refresh: true,
        }),
        vue(),
    ],
     resolve: {
        alias: {
             vue: 'vue/dist/vue.esm-bundler.js',
            ui:'resources/scss/__variable.scss'
        },
    },
});
