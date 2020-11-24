<?php

namespace App\AdipUtils;

/**
 * 
 */
final class Engine{

    /**
     * Fecha del arquetipo
     * 
     */
    public const BUILD_DATE = '2020-10-12 18:21 UTC -5';



    /**
     * Desactiva la instanciación de la clase
     * 
     */
    private function __construct(){

    }


    /**
     * URL Base para invitados (doble login)
     * 
     * @return String
     */
    public static function guestUrlBase():String{
        return config('engine.guest_zone', 'invitados');
    }


    
}