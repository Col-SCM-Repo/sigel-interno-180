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
Route::prefix('pagos')->middleware('auth')->group(function () {
    #pagos
    Route::get('/', ['uses' => 'PagosController@index', 'as' => 'index.pagos']);
    Route::post('/obtener_alumnos', ['uses' => 'PagosController@ObtenerAlumnos', 'as' => 'obtener.alumnos.pagos']);
    Route::post('/obtener_pagos', ['uses' => 'PagosController@ObtenerPagosPorCronogramaId', 'as' => 'obtener.por.cronograma.pagos']);
    Route::post('/guardar_pago', ['uses' => 'PagosController@GuardarPago', 'as' => 'guardar.pago.pagos']);

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
//Routes anio
Route::prefix('reportes')->middleware('auth')->group(function () {
    #Dashboard
    Route::get('/boleta/{pago_id}', ['uses' => 'ReportesController@VerBoleta', 'as' => 'boleta.reportes']);
});
Route::get('/pruebas', 'Pruebas@ObtenerUsuarios')->name('pruebas');
