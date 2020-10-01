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
| Web Routes
|--------------------------------------------------------------------------
|
| Rutas con ejemplos. Se pueden comentar o eliminar
|
*/

Route::group(['prefix' => 'examples'], function() { 
    Route::get('/upload-files.php', function () { return view('examples.uploadfilesform'); })->middleware('auth')->name('examples.uploadfilesform');
    Route::post('/upload-filesB.php', 'ExamplesController@uploadFile')->name('examples.uploadfiles');
});