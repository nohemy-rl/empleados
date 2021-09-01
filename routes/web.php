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
    return view('auth/login');
});

Route::get('/consultasajax/getdepartamentobyempresa/{empresa_id}', 'ConsultasAjaxController@getdepartamentobyempresa')->name('consultasajax.getdepartamentobyempesa');

Auth::routes();
Route::resources([
    'empresa' => 'EmpresaController',
    'departamento' => 'DepartamentoController',
    'empleado' => 'EmpleadoController',
    'usuario' => 'UsuarioController',
]);


Route::get('/home', 'HomeController@index')->name('home');
