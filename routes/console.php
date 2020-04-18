<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use App\AdipUtils\{ArrayList, Constants, MandrillMail, SimpleCURL};

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->describe('Display an inspiring quote');

Artisan::command('algo', function () {
    $c = new SimpleCURL;
    $c->setUrl('http://adip.io');
    var_dump($c);
})->describe('Pruebas del manual');
