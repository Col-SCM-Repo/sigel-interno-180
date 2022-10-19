const mix = require("laravel-mix");

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

mix.js("resources/js/app.js", "public/js").sass(
    "resources/sass/app.scss",
    "public/css"
);
// modulo Pagos y Matriculas
//crongrama
mix.js("resources/js/cronograma/index.js", "public/js/cronograma");
//alumnos
mix.js("resources/js/alumnos/index.js", "public/js/alumnos")
    .js("resources/js/alumnos/editar.js", "public/js/alumnos")
    .js("resources/js/alumnos/morosos.js", "public/js/alumnos");
//vacantes
mix.js("resources/js/vacantes/por_anio.js", "public/js/vacantes").js(
    "resources/js/vacantes/total_alumno_anio_nivel.js",
    "public/js/vacantes"
);
//reportes - pagos
mix.js("resources/js/pagos/pagos_entre_fechas.js", "public/js/pagos").js(
    "resources/js/pagos/fecha_por_usuario_actual.js",
    "public/js/pagos"
);
//matriculas
mix.js("resources/js/matriculas/nueva.js", "public/js/matriculas");
//Año Escolar
mix.js("resources/js/anioAcademico/index.js", "public/js/anioAcademico");
//Usuarios
mix.js("resources/js/usuarios/index.js", "public/js/usuarios");
// modulo Notas Academicas
//Alumnos
mix.js(
    "resources/js/modulos/notasAcademicas/alumnos/index.js",
    "public/js/modulos/notasAcademicas/alumnos"
);
//notas
mix.js(
    "resources/js/modulos/notasAcademicas/notas/index.js",
    "public/js/modulos/notasAcademicas/notas"
);

//Reloj
mix.js("resources/js/reloj/index.js", "public/js/reloj");
mix.js("resources/js/reloj/alumnos.js", "public/js/reloj");
mix.js("resources/js/reloj/empleados.js", "public/js/reloj");
