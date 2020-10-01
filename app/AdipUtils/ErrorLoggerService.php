<?php

namespace App\AdipUtils;

use App\Models\ErrorLogger;
use Illuminate\Support\Str;
use Auth;

class ErrorLoggerService
{
    /**
     * Desactivar instanciación de clase
     */
    private function __construct(){}
    

    /**
     * Almacena un registro en la bitácora de errores/eventos del arquetipo
     * 
     * @param String $nivel Origen del error, se recomienda usar __METHOD__
     * @param String $desc Descripcion del error (informacion para el desarrollador)
     * @param int $response Código de respuesta HTTP que se enviará, 0 si no hay
     * @return String $uuid ID de petición
     */
    public static function log(String $nivel, String $desc, int $response = 0):String{
        $idUsuario = Auth::check()?Auth::user()->idUsuario:0;
        
        $uuid = session()->get('requuid');
        ErrorLogger::create(
            [
                'tx_uuid' => $uuid,
                'tx_nivel' => $nivel,
                'tx_detalle' => $desc,
                'tx_request_uri' => request()->path(),
                'tx_session_token' => session()->get('ix_token')??'',
                'nu_http_response' => $response,
                'idUsuario' => $idUsuario??0
            ]
        );
        return $uuid;
    }
}
