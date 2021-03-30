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

mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css');
//pagos
mix.js('resources/js/pagos/index.js', 'public/js/pagos');
//crongrama
mix.js('resources/js/cronograma/index.js', 'public/js/cronograma');

//crongrama
mix.js('resources/js/alumnos/index.js', 'public/js/alumnos');
