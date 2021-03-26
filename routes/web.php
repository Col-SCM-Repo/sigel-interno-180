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

Route::get('/home', 'HomeController@index')->name('home');
//Routes Web
Route::prefix('pagos')->middleware('auth')->group(function () {
    #Dashboard
      Route::get('/', ['uses' => 'PagosController@index', 'as' => 'index.pagos']);
      Route::post('/obtener_alumnos', ['uses' => 'PagosController@ObtenerAlumnos', 'as' => 'obtener.alumnos.pagos']);
  });

Route::prefix('anios')->middleware('auth')->group(function () {
#Dashboard
    Route::get('/obtener_anios', ['uses' => 'AniosController@ObtenerAnios', 'as' => 'obtener.anios']);
});
