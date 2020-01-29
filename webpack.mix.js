const mix = require('laravel-mix');
require('laravel-mix-merge-manifest');

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

// merge manifest from different configs
mix.mergeManifest();

if (mix.inProduction()) {
    mix.sourceMaps().version();
}

if (process.env.section) {
    require(`${__dirname}/webpack.mix.${process.env.section}.js`);
}
