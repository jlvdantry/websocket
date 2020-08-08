<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AdipUtils\{ArrayList, FileService};
use App\Models\Correo;
use App\Models\Archivo;


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
        // Ejemplo con \SplFileInfo
        // $f = new \SplFileInfo(
        //     storage_path('app'.DIRECTORY_SEPARATOR.'response_lc_pago_1018.xml')
        // ); // Reemplazar por un archivo que exista.
        // $korreo = new Correo([
        //     'tx_from' => config('mail.from.adderss', 'no-reply@cdmx.gob.mx')
        //     ,'tx_to' => 'underdog1987@yandex.ru'
        //     ,'tx_subject' => 'Prueba de archivo adjunto'
        //     ,'tx_body' => 'Kindly check the attached loveletter comming from me'
        //     ,'nu_priority' => 0        
        // ]);
        // $korreo->save();
        // $korreo->withFiles($f);

        // Ejemplo con un uuid de un archivo que exista en la BD.
        // $uuid = '9a443e01-6dee-4b1a-a57c-9e968b85084e';
        // $objArchivo = Archivo::where('tx_uuid', '=', $uuid)->first();
        // $korreo = new Correo([
        //     'tx_from' => config('mail.from.adderss', 'no-reply@cdmx.gob.mx')
        //     ,'tx_to' => 'underdog1987@yandex.ru'
        //     ,'tx_subject' => 'Prueba de archivo adjunto'
        //     ,'tx_body' => 'Kindly check the attached loveletter comming from me'
        //     ,'nu_priority' => 0        
        // ]);
        // $korreo->save();
        // $korreo->withFiles($objArchivo);

        // Ejemplo con ArrayList (adjuntar varios archivos)
        $uuid = '9a443e01-6dee-4b1a-a57c-9e968b85084e';
        $fileZ= new ArrayList;
        $f = new \SplFileInfo(
            storage_path('app'.DIRECTORY_SEPARATOR.'response_lc_pago_1018.xml')
        );
        $objArchivo = Archivo::where('tx_uuid', '=', $uuid)->first();
        $fileZ->add($f);
        $fileZ->add($objArchivo);
        $korreo = new Correo([
            'tx_from' => config('mail.from.adderss', 'no-reply@cdmx.gob.mx')
            ,'tx_to' => 'underdog1987@yandex.ru'
            ,'tx_subject' => 'Prueba de archivos adjuntos'
            ,'tx_body' => '2 archivaldos'
            ,'nu_priority' => 0        
        ]);
        $korreo->save();
        $korreo->withFiles($fileZ);




        return view('home');
    }
}
