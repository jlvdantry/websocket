<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\AdipUtils\ErrorLoggerService as Logg;
use Illuminate\Support\Str;

class ApiController extends Controller{

    private const USER_AGENT = 'Mozilla/5.0 (Windows NT 10.0; WOW64) ADIP(CDMX)/Endpoint Client';
    private $requuid;

    /**
     * Metodo de ejemplo que muestra los datos de la app que consume la API
     */
    public function register(Request $r){
        // Estas líneas son obligatorias, no eliminar
        if(!$this->validateRequest($r)){            
            if($r->expectsJson()){
                return \Response::json([
                    'mensaje' => 'No permitido',
                    'codigo' => 403
                ], 403);
            }else{
                abort(403);
            }
        }
        // Comenzar aquí el cuerpo del método
        return Auth::user();
    }


    /* No editar a partir de aquí */
    private function validateRequest(Request $rr):bool{
        // Asignarle identificador a la petición
        $this->requuid = Str::uuid()->toString();
        session()->put('requuid', $this->requuid);
        // Validacion
        $validated=TRUE;
        // 'Authorization' => 'Bearer '.$token,
        if($rr->header('User-Agent') === NULL || $rr->header('User-Agent') !== self::USER_AGENT ){
            Logg::log(__METHOD__,'La petición no superó la prueba (user-agent)', 403);
            $validated=FALSE;
        }
        
        if($rr->header('dependencia-id') === NULL ){
            Logg::log(__METHOD__,'La petición no superó la prueba (dependencia id)', 403);
            $validated=FALSE;
        }
        return $validated;
    }
}
