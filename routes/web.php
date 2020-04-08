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

Auth::routes(
    [
        'register' => FALSE, 
        'reset'    => FALSE, 
        'verify'   => FALSE, 
    ]
);
Route::get('/', function () {
    return view('welcome');
})->name('welcome');
Route::get('/home', 'HomeController@index')->name('home');

// todo lo que tenga que ver con servicios
Route::group(['prefix' => 'service', 'namespace'=>'AdipServices'], function() {    
    Route::get('/session/getSession', 'SessionService@getSession')->name('getSession');
});
