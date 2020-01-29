const mix = require('laravel-mix');

mix.options({
    extractVueStyles: 'public/css/auth/auth.css',
    postCss: [
        require('postcss-preset-env'),
        require('tailwindcss'),
    ],
});

mix.js('resources/js/auth.js', 'public/js/auth')
    .extract(['vue']);
