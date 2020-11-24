<?php

namespace App\Http\Controllers\AdipServices;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\AdipUtils\ErrorLoggerService as Logg;


class SessionService extends Controller
{
    public function __construct(){
        //$this->middleware('auth');
    }

    /**
     * Obtiene validacion de sesion.
     * 
     * @param  \Illuminate\Http\Request  $r
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

        $u=NULL;
        if(Auth::guard('invitado')->check() ){
            $u = Auth::guard('invitado')->user()->id;
        }

        if(Auth::check() ){
            $u = Auth::user()->idUsuario;
        }


        if( $u ===NULL){
            return \Response::json([
                'mensaje' => 'No autenticado',
                'codigo' => 401,
            ], 401);
        }
        
        return \Response::json([
            'mensaje' => 'OK',
            'codigo' => 200,
            'u' => $u
        ], 200);
    }

}
