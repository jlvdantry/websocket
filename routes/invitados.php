<?php

use Illuminate\Support\Facades\Route;
use App\AdipUtils\Engine;

/*
|--------------------------------------------------------------------------
| Rutas invitados
|--------------------------------------------------------------------------
|
| Las rutas establecidas en este archivo son utilizadas por los invitados
|
*/


Route::get(Engine::guestUrlBase().'/login', 'Auth\InvitadoLoginController@showLoginForm')->name('invitados.login');
Route::post(Engine::guestUrlBase().'/login', 'Auth\InvitadoLoginController@login')->name('invitados.loginPost');
Route::post(Engine::guestUrlBase().'/logout', 'Auth\InvitadoLoginController@logout')->name('invitados.logout');


Route::group(['prefix' => Engine::guestUrlBase(), 'namespace'=>'Invitados'], function() {    
    Route::get('/', 'HomeController@index')->name('invitados.home');
});