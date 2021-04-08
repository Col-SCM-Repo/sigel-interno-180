<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('login');
});

Auth::routes();
//principal
Route::get('/home', 'HomeController@index')->name('home');
//Routes pagos
Route::prefix('alumnos')->middleware('auth')->group(function () {
    #pagos
    Route::get('/', ['uses' => 'AlumnosController@index', 'as' => 'index.alumnos']);
    Route::post('/obtener_alumnos', ['uses' => 'AlumnosController@ObtenerAlumnos', 'as' => 'obtener.alumnos']);
    Route::post('/obtener_alumnos_por_aula', ['uses' => 'AlumnosController@ObtenerAlumnosPorAula', 'as' => 'obtener.por.aula.alumnos']);
    #editar
    Route::get('/editar/{alumno_id}', ['uses' => 'AlumnosController@Editar', 'as' => 'editar.alumno.alumnos']);
    Route::post('/obtener_datos_alumno', ['uses' => 'AlumnosController@ObtenerAlumnoPorID', 'as' => 'datos.alumno.por.id.alumnos']);
    Route::post('/guardar', ['uses' => 'AlumnosController@Guardar', 'as' => 'datos.alumno.por.id.alumnos']);
    #
    Route::post('/buscar_por_dni', ['uses' => 'AlumnosController@ObtenerAlumnoPorDNI', 'as' => 'buscar.alumno.por.dni.alumnos']);
});
//Routes Matriculas
Route::prefix('matriculas')->middleware('auth')->group(function () {
    Route::post('/obtener_matriculas_por_alumno', ['uses' => 'MatriculasController@ObtenerMatriculasPorAlumno', 'as' => 'obtener.alumnos.matriculas']);
    #nueva
    Route::get('/nueva/{alumno_id}', ['uses' => 'MatriculasController@NuevaVista', 'as' => 'nueva.matriculas']);
    Route::get('/obtener_modelo', ['uses' => 'MatriculasController@ModeloMatricula', 'as' => 'modelo.matriculas']);
});
//Routes pagos
Route::prefix('pagos')->middleware('auth')->group(function () {
    #pagos
    Route::post('/obtener_pagos', ['uses' => 'PagosController@ObtenerPagosPorCronogramaId', 'as' => 'obtener.por.cronograma.pagos']);
    Route::post('/guardar_pago', ['uses' => 'PagosController@GuardarPago', 'as' => 'guardar.pago.pagos']);
    Route::post('/guardar_nota_credito', ['uses' => 'PagosController@GuardarNotaCredito', 'as' => 'guardar.nota.credito.pagos']);
    #pagos del dia
    Route::get('/del_dia', ['uses' => 'PagosController@PagosDelDiaVista', 'as' => 'vista.pagos.del.dia.pagos']);
    Route::post('/obtener_pagos_del_dia', ['uses' => 'PagosController@ObtenerPagosDelDia', 'as' => 'obtener.pagos.del.dia.pagos']);
});
//Routes anio
Route::prefix('anios')->middleware('auth')->group(function () {
    #Dashboard
    Route::get('/obtener_anios', ['uses' => 'AniosController@ObtenerAnios', 'as' => 'obtener.anios']);
});
//Routes Cronograma Pagos
Route::prefix('cronograma')->middleware('auth')->group(function () {
    #Dashboard
    Route::get('/{matricula_id}', ['uses' => 'CronogramaController@Index', 'as' => 'index.cronograma']);
    Route::post('/obtener_datos', ['uses' => 'CronogramaController@ObtenerCronogramasPorMatriculaID', 'as' => 'obtener.por.matricula.cronograma']);
    Route::post('/obtener_saldo', ['uses' => 'CronogramaController@ObtenerSaldoDeCronograma', 'as' => 'obtener.saldo.de.cronograma.pagos']);
});
//Routes aulas
Route::prefix('aulas')->middleware('auth')->group(function () {
    #Dashboard
    Route::get('/', ['uses' => 'VacanteController@Index', 'as' => 'index.aula']);
    Route::post('/obtener_aulas', ['uses' => 'VacanteController@ObtenerAulasPorAnio', 'as' => 'obtener.aulas.anios.aula']);
});
//Routes anios
Route::prefix('anios')->middleware('auth')->group(function () {
    #Dashboard
    Route::get('/obtener_anios', ['uses' => 'AnioAcademicoController@ObtenerAnios', 'as' => 'obtener.anios']);
});
//Routes reportes
Route::prefix('reportes')->middleware('auth')->group(function () {
    Route::get('/boleta/{pago_id}', ['uses' => 'ReportesController@VerBoleta', 'as' => 'boleta.reportes']);
    Route::post('/descargar_lista', ['uses' => 'ReportesController@DescargarListaAlumnos', 'as' => 'descargar.lista.alumnos']);
    Route::post('/descargar_resumen', ['uses' => 'ReportesController@DescargarResumen', 'as' => 'obtener.pagos.del.dia.pagos']);
    // Route::post('/descargar_pagos_del_dia', ['uses' => 'ReportesController@DescargarPagosDelDia', 'as' => 'obtener.pagos.del.dia.pagos']);
});
//Routes anios
Route::prefix('paises')->middleware('auth')->group(function () {
    #Dashboard
    Route::get('/obtener_paises', ['uses' => 'PaisesController@ObtenerPaises', 'as' => 'obtener.paises']);
});
Route::prefix('distritos')->middleware('auth')->group(function () {
    #Dashboard
    Route::get('/obtener_distritos', ['uses' => 'DistritosController@ObtenerDistritos', 'as' => 'obtener.distritos']);
});
Route::prefix('apoderados')->middleware('auth')->group(function () {
    #Dashboard
    Route::post('/obtener_por_alumno', ['uses' => 'ApoderadosController@ObtenerPorAlumno', 'as' => 'obtener.por.alumno.apoderados']);
    Route::get('/modelo', ['uses' => 'ApoderadosController@ModeloApoderado', 'as' => 'modelo.apoderados']);
    Route::post('/guardar', ['uses' => 'ApoderadosController@GuardarApoderado', 'as' => 'guardar.apoderados']);
});
Route::prefix('vacantes')->middleware('auth')->group(function () {
    #Dashboard
    Route::post('/obtener_por_nivel_grado_anio_actual', ['uses' => 'VacantesController@ObtenerPorNivelGradoDelAnioActual', 'as' => 'obtener.por.nivel.grado.anio_actual.vacantes']);
});
Route::prefix('religiones')->middleware('auth')->group(function () {
    #Dashboard
    Route::get('/obtener_religiones', ['uses' => 'ReligionesController@ObtenerReligiones', 'as' => 'obtener.religiones']);
});
Route::prefix('tipo_documento')->middleware('auth')->group(function () {
    #Dashboard
    Route::get('/obtener_tipos', ['uses' => 'TipoDocumentoController@ObtenerTipos', 'as' => 'obtener.tipo_documento']);
});
Route::prefix('tipo_parentesco')->middleware('auth')->group(function () {
    #Dashboard
    Route::get('/obtener_tipos', ['uses' => 'TipoParentescoController@ObtenerTipos', 'as' => 'obtener.tipo_parentesco']);
});
Route::prefix('grado_instrucion')->middleware('auth')->group(function () {
    #Dashboard
    Route::get('/obtener_grados', ['uses' => 'GradoInstruccionController@ObtenerGrados', 'as' => 'obtener.grados_instruccion']);
});
Route::prefix('centro_laboral')->middleware('auth')->group(function () {
    #Dashboard
    Route::get('/obtener_centros', ['uses' => 'CentroLaboralController@ObtenerCentros', 'as' => 'obtener.centro_laboral']);
});
Route::prefix('ocupacion')->middleware('auth')->group(function () {
    #Dashboard
    Route::get('/obtener_ocupaciones', ['uses' => 'OcupacionesController@ObtenerOcupaciones', 'as' => 'obtener.ocupacion']);
});
Route::prefix('conceptos')->middleware('auth')->group(function () {
    #Dashboard
    Route::get('/obtener_conceptos_anio_actual', ['uses' => 'ConceptosController@ObtenerConceptosDelAnioActual', 'as' => 'obtener.ocupacion']);
});
Route::get('/pruebas', 'Pruebas@ObtenerUsuarios')->name('pruebas');
