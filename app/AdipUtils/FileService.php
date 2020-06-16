<?php

namespace App\AdipUtils;

use App\Models\Archivo;
use App\AdipUtils\ErrorLoggerService as Logg;
use Carbon\Carbon;

final class FileService{

    private const STORAGE_FOLDER_NAME = 'app_archivos';
    
    private function __construct(){	}

    
    public static function getFile(String $txUUID, $download = FALSE){
        $archs = Archivo::where('tx_uuid','=',$uuid)->get();
        if(count($archs)===1){
            $arch = $archs[0];
            $realArch = storage_path('app'.DIRECTORY_SEPARATOR.self::STORAGE_FOLDER_NAME.DIRECTORY_SEPARATOR.$arch->tx_uuid.'.dat');
            if ( file_exists($realArch) ){
                return $download?response()->file($realArch):$arch;
            }else{
                Logg::log(__METHOD__,'No se encontró el archivo '.$uuid, 404);
                abort(404, "No encontrado");
            }
        }else{
            Logg::log(__METHOD__,'El UUID devuelve un valor diferente a 1.', 500);
            abort(500);
        }
    }
	
}