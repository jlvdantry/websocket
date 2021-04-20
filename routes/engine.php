<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Rutas arquetipo
|--------------------------------------------------------------------------
|
| Las rutas establecidas en este archivo son utilizadas por el arquetipo
|
*/

Route::group(['prefix' => 'service', 'namespace'=>'AdipServices'], function() {    
    Route::get('/session/getSession', 'SessionService@getSession')->name('getSession');
    
    Route::get('/storage/public/{uuid}', 'StorageController@showPublicFileByUuid')->name('publicFileByUuid');
    Route::get('/storage/getFile/{uuid}', 'StorageController@downloadFileByUuid')->name('downloadFileByUuid');
    Route::get('/storage/viewFile/{uuid}', 'StorageController@showFileByUuid')->name('showFileByUuid');
    Route::post('/storage/upload/', 'StorageController@uploadFile')->name('uploadFile');
});


/*
|--------------------------------------------------------------------------
| Rutas perfil de usuario
|--------------------------------------------------------------------------
|
| Las rutas establecidas en este bloque son para el perfil de usuario
|
*/
Route::group(['prefix' => 'user-profile', /*'namespace'=>'AdipServices'*/], function() {    
    Route::get('/', function () { trigger_error('Not implemented yet'); })->name('engine.user-profile');
});


Route::get('/robots.txt', 'MetaController@getRobotsFile')->name('robots_txt');
Route::get('/humans.txt', 'MetaController@getHumansFile')->name('humans_txt');
Route::get('/.well-known/security.txt', 'MetaController@getSecurityFile')->name('security_txt');


/*
|--------------------------------------------------------------------------
| Ejemplos
|--------------------------------------------------------------------------
|
| Rutas con ejemplos. Se pueden comentar o eliminar
|
*/

Route::group(['prefix' => 'examples'], function() { 
    Route::get('/upload-files.php', function () { return view('examples.uploadfilesform'); })->middleware('auth')->name('examples.uploadfilesform');
    Route::post('/upload-filesB.php', 'ExamplesController@uploadFile')->name('examples.uploadfiles');

    Route::get('/hello-basic-auth', 'Examples\BasicAuthController@index')->name('examples.basicauth');

});