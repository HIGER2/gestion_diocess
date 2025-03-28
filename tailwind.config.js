import defaultTheme from 'tailwindcss/defaultTheme';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
    ],
    theme: {
        extend: {
            colors: {
                primary: {
                    DEFAULT: '#243955',
                    // DEFAULT: '#163300',
                    // DEFAULT: '#9fe870',
                    // dark: '#1558b5',
                    // light: '#4285f4',
                },
                secondary: {
                    DEFAULT: '#fff',
                    dark: '#e65100',
                    light: '#ffc947',
                },
                customGray: '#f6f6f6',
                custom: '#16330014',
                // custom: '#16330014',
            },
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },
    plugins: [],
};
