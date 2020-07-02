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

// todo lo que tenga que ver con servicios
Route::group(['prefix' => 'service', 'namespace'=>'AdipServices'], function() {    
    Route::get('/session/getSession', 'SessionService@getSession')->name('getSession');
    
    Route::get('/storage/getFile/{uuid}', 'StorageController@downloadFileByUuid')->name('downloadFileByUuid');
    Route::get('/storage/viewFile/{uuid}', 'StorageController@showFileByUuid')->name('showFileByUuid');
    Route::post('/storage/upload/', 'StorageController@uploadFile')->name('uploadFile');
    
});



// Ejemplos arquetipo (este bloque de rutas se puede comentar o  borrar)
    // Formulario
    Route::get('/examples/upload-files.php', function () { return view('examples.uploadfilesform'); })->middleware('auth')->name('examples.uploadfilesform');
    Route::post('/examples/upload-filesB.php', 'ExamplesController@uploadFile')->name('examples.uploadfiles');