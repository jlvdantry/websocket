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


Route::get(Engine::guestZone().'/login', 'Auth\InvitadoLoginController@showLoginForm')->name('invitados.login');
Route::post(Engine::guestZone().'/login', 'Auth\InvitadoLoginController@login')->name('invitados.loginPost');
Route::post(Engine::guestZone().'/logout', 'Auth\InvitadoLoginController@logout')->name('invitados.logout');


Route::group(['prefix' => Engine::guestZone(), 'namespace'=>'Invitados'], function() {    
    Route::get('/', 'HomeController@index')->name('invitados.home');
});