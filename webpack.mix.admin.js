const mix = require('laravel-mix');

mix.options({
    extractVueStyles: 'public/css/admin/admin.css',
    postCss: [
        require('postcss-preset-env'),
        require('tailwindcss'),
    ],
});

mix.js('resources/js/admin.js', 'public/js/admin')
    .extract(['vue']);
