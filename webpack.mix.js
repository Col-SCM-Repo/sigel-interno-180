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
//crongrama
mix.js('resources/js/cronograma/index.js', 'public/js/cronograma');
//alumnos
mix.js('resources/js/alumnos/index.js', 'public/js/alumnos');
//alumnos
mix.js('resources/js/aulas/index.js', 'public/js/aulas');
//reportes - pagos
mix.js('resources/js/pagos/del_dia.js', 'public/js/pagos');
