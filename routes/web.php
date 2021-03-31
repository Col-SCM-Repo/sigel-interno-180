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
});
//Routes Matriculas
Route::prefix('matriculas')->middleware('auth')->group(function () {
    Route::post('/obtener_matriculas_por_alumno', ['uses' => 'MatriculasController@ObtenerMatriculasPorAlumno', 'as' => 'obtener.alumnos']);
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
//Routes aulas
Route::prefix('anios')->middleware('auth')->group(function () {
    #Dashboard
    Route::get('/obtener_anios', ['uses' => 'AnioAcademicoController@ObtenerAnios', 'as' => 'obtener.anios']);
});
//Routes reportes
Route::prefix('reportes')->middleware('auth')->group(function () {
    #Dashboard
    Route::get('/boleta/{pago_id}', ['uses' => 'ReportesController@VerBoleta', 'as' => 'boleta.reportes']);
});
Route::get('/pruebas', 'Pruebas@ObtenerUsuarios')->name('pruebas');
