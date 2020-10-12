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

    'mandrillsecret' => env('MANDRILL_SECRET_APP_SUFIX'),

    'mandrillurl' => env('MANDRILL_URL_APP_SUFIX'),

    
    /*
    |--------------------------------------------------------------------------
    | Google Maps
    |--------------------------------------------------------------------------
    |
    | En este valor se especifica la URL a la que direcciona el sistema llave
    | una vez que se lleve a cabo un inicio de sesión exitoso.
    */

    'gmaps' => env('GMAPS_API_KEY_APP_SUFIX'),



    /*
    |--------------------------------------------------------------------------
    | Reporte de errores por correo
    |--------------------------------------------------------------------------
    |
    | En este valor se especifica un correo electrónico al cual se envian los
    | reportes de error especificados en Handler::report().
    */

    'mailing_errors' => env('ERROR_REPORT_MAIL_APP_SUFIX'),



    /*
    |--------------------------------------------------------------------------
    | Prevenir session-hijacking
    |--------------------------------------------------------------------------
    |
    | En este valor se especifica TRUE o FALSE para indicar si se cierra la
    | sesión al cambiar el user agent. Predeterminado: TRUE
    */

    'validate_ua' => env('VALIDATE_UA_APP_SUFIX', TRUE),



    /*
    |--------------------------------------------------------------------------
    | Prevenir session-hijacking
    |--------------------------------------------------------------------------
    |
    | En este valor se especifica TRUE o FALSE para indicar si se cierra la
    | sesión al cambiar la IP. Predeterminado: TRUE
    */

    'validate_ip' => env('VALIDATE_UA_APP_SUFIX', TRUE),


];
