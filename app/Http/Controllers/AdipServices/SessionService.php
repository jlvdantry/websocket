<?php

namespace App\Http\Controllers\AdipServices;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\AdipUtils\ErrorLoggerService as Logg;


class SessionService extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    /**
     * Obtiene lineas de vehículo por marca.
     * 
     * @param  \Illuminate\Http\Request  $r
     * @param  int $idMarca
     * @return \Illuminate\Http\Response
     */
    public function getSession(Request $r){
		if(! $r->ajax()){
            Logg::log(__METHOD__,'El recurso solo está disponible vía AJAX', 403);
			return \Response::json([
				'mensaje' => 'No permitido',
				'codigo' => -1,
			], 403);
        }
        if( Auth::user() !==NULL){
            $u=Auth::user()->idUsuario;
        }else{
            $u=0;
        }
        return \Response::json([
            'mensaje' => 'OK',
            'codigo' => 200,
            'u' => $u
        ], 200);
    }

}
