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

// Deshabilita rutas de registro de usuarios, reset password y verificar usuario
Auth::routes(
    [
        'register' => FALSE, 
        'reset'    => FALSE, 
        'verify'   => FALSE, 
    ]
);

// Ruta de bienvenida
Route::get('/', function () { return view('welcome'); })->name('welcome');
// Home
Route::get('/home', 'HomeController@index')->name('home');

