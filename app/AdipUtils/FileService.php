<?php

namespace App\AdipUtils;

use App\Models\Archivo;
use App\AdipUtils\ErrorLoggerService as Logg;
use Carbon\Carbon;
use Str;
use Auth;
use Illuminate\Http\UploadedFile;

final class FileService{

    private const STORAGE_FOLDER_NAME = 'app_archivos';
    
    private function __construct(){	}

    
    public static function getFile(String $uuid){
        $archs = Archivo::where('tx_uuid','=',$uuid)->get();
        if(count($archs)===1){
            $arch = $archs[0];
            $realArch = storage_path('app'.DIRECTORY_SEPARATOR.self::STORAGE_FOLDER_NAME.DIRECTORY_SEPARATOR.$arch->tx_uuid.'.dat');
            if ( file_exists($realArch) ){
                return (Object)['real_path' => $realArch, 'archivo' => $arch];
            }else{
                Logg::log(__METHOD__,'No se encontró el archivo '.$uuid, 404);
                abort(404, "No encontrado");
            }
        }else{
            Logg::log(__METHOD__,'El UUID devuelve un valor diferente a 1.', 500);
            abort(500);
        }
    }

    public static function store(UploadedFile $archivo):Object{
        $toSave = new Archivo;
        $toSave->nb_archivo = $archivo->getClientOriginalName();
        $toSave->tx_mime_type = $archivo->getMimeType();
        $toSave->nu_tamano = $archivo->getSize();
        $toSave->tx_uuid = Str::uuid()->toString();
        $toSave->tx_sha256 = hash_file('sha256',$archivo->path());
        $toSave->usr_alta = Auth::user()->idUsuario;
        $archivo->storeAs(self::STORAGE_FOLDER_NAME, $toSave->tx_uuid.'.dat');
        $toSave->save();
        return (Object)[
            'nb_archivo' => $toSave->nb_archivo,
            'tx_mime_type' => $toSave->tx_mime_type,
            'nu_tamano' => $toSave->nu_tamano,
            'tx_uuid' => $toSave->tx_uuid,
        ];
    }
	
}