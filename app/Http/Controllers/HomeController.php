<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AdipUtils\FileService;
use App\Models\Correo;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $f = new \SplFileInfo(
            storage_path('app'.DIRECTORY_SEPARATOR.'response_lc_pago_1018.xml')
        );
        //$res = FileService::addToStorage($f);
        $korreo = new Correo([
            'tx_from' => config('mail.from.adderss', 'no-reply@cdmx.gob.mx')
            ,'tx_to' => 'underdog1987@yandex.ru'
            ,'tx_subject' => 'Prueba de archivo adjunto'
            ,'tx_body' => 'Kindly check the attached loveletter comming from me'
            ,'nu_priority' => 0        
        ]);
        $korreo->save();
        //$korreo->archivos()->attach($res->id);
        $korreo->withFiles($f);
        return view('home');
    }
}
