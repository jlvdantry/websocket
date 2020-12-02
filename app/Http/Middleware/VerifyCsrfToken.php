<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;
use App\AdipUtils\ErrorLoggerService as Logg;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        //
    ];




    /**
     * Determine if the session and input CSRF tokens match.
     *
     * @override
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function tokensMatch($request)
    {
        $token = $this->getTokenFromRequest($request);

        $ret = is_string($request->session()->token()) &&
               is_string($token) &&
               hash_equals($request->session()->token(), $token);
        if(!$ret){
            try{
                Logg::log(__METHOD__,'Token no coincide. Se esperaba '.$request->session()->token().' pero se recibió '.$token );
            }catch(\Exception $e){
                
            }
        }
        return $ret;
    }
}
