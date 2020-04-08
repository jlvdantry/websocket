<?php

namespace App\AdipUtils;

use App\Models\ErrorLogger;
use Illuminate\Support\Str;
use Auth;

class ErrorLoggerService
{
    private function __construct(){}
    //
    public static function log(string $nivel, string $desc, int $response = 0):String{
        $idUsuario = Auth::user()!==NULL? Auth::user()->idUsuario:0;
        $uuid = session()->get('requuid');
        ErrorLogger::create(
            [
                'tx_uuid' => $uuid,
                'tx_nivel' => $nivel,
                'tx_detalle' => $desc,
                'tx_request_uri' => request()->path(),
                'tx_session_token' => session()->get('ix_token')??'',
                'nu_http_response' => $response,
                'idUsuario' => $idUsuario
            ]
        );
        return $uuid;
    }
}
