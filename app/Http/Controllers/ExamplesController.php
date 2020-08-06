<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AdipUtils\FileService;
use App\Models\Correo;
//use App\Models\Archivo;

class ExamplesController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    
    public function uploadFile(Request $r){
        if($r->hasFile('biArchivo')){
            $public = isset($r->chkPublic) && $r->chkPublic == 1;
            $sendMailWithFile = isset($r->chkSendMail) && $r->chkSendMail == 1;
            $saved = FileService::store($r->file('biArchivo'), $public);
            /* Envía como archivo adjunto un archivo cargado por el usuario */
            if($sendMailWithFile){
                // Ejemplo 1: Con lista de correo
                $korreo = new Correo([
                    'tx_from' => config('mail.from.adderss', 'no-reply@cdmx.gob.mx')
                    ,'tx_to' => 'underdog1987@yandex.ru'
                    ,'tx_subject' => 'Prueba de archivo adjunto'
                    ,'tx_body' => 'Kindly check the attached loveletter comming from me'
                    ,'nu_priority' => 0        
                ]);
                $korreo->save();
                $korreo->archivos()->attach($saved->id);
                // Ejemplo 2: Con MailFactory
                // $korreo = new Correo([
                //     'tx_from' => config('mail.from.adderss', 'no-reply@cdmx.gob.mx')
                //     ,'tx_to' => 'underdog1987@yandex.ru'
                //     ,'tx_subject' => 'Prueba de archivo adjunto'
                //     ,'tx_body' => 'Kindly check the attached loveletter comming from me'
                //     ,'nu_priority' => 0        
                // ]);
                // $korreo->save();
                // $korreo->archivos()->attach($saved->id);
                // $foo = MailFactory::sendMail($korreo);
            }
            return view('examples.file-uploaded')->with(compact('saved', 'public'));
        }
    }
}
