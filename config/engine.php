<?php
/**
 * Archivo de configuración miscelanea del arquetipo
 */
return [

    /*
    |--------------------------------------------------------------------------
    | Mandrill
    |--------------------------------------------------------------------------
    |
    | Valores para consumir el API de Mandrill para elenvío de correos
    |
    */

    'mandrillsecret' => env('MANDRILL_SECRET'),

    'mandrillurl' => env('MANDRILL_URL'),

    
    /*
    |--------------------------------------------------------------------------
    | Google Maps
    |--------------------------------------------------------------------------
    |
    | En este valor se especifica la URL a la que direcciona el sistema llave
    | una vez que se lleve a cabo un inicio de sesión exitoso.
    */

    'gmaps' => env('GMAPS_API_KEY'),


];
