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
mix.js('resources/js/alumnos/index.js', 'public/js/alumnos')
    .js('resources/js/alumnos/editar.js', 'public/js/alumnos');
//aulas
mix.js('resources/js/aulas/index.js', 'public/js/aulas')
   .js('resources/js/aulas/cant_alumnos_nivel.js', 'public/js/aulas');
//reportes - pagos
mix.js('resources/js/pagos/del_dia.js', 'public/js/pagos');
//matriculas
mix.js('resources/js/matriculas/nueva.js', 'public/js/matriculas');
