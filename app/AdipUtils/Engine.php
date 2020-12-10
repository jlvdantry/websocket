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
    public const BUILD_DATE = '2020-12-10 14:20 UTC -6';



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
    public static function guestZone():String{
        return config('engine.guest_zone', 'invitados');
    }


    
}