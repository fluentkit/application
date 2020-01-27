const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

// hack because mix looks for artisan binary?
mix.setPublicPath('public');

mix.options({
    extractVueStyles: 'public/css/admin.css',
    postCss: [
        require('postcss-preset-env'),
        require('tailwindcss'),
    ],
});

mix.js('resources/js/app.js', 'public/js')
    .js('resources/js/admin.js', 'public/js')
    .extract(['vue'])
    .sourceMaps();

if (mix.inProduction()) {
    mix.version();
}
