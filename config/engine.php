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
    | con MailFactory
    |
    */

    'mandrillsecret' => env('MANDRILL_SECRET_APP_SUFIX'),

    'mandrillurl' => env('MANDRILL_URL_APP_SUFIX'),

    
    /*
    |--------------------------------------------------------------------------
    | Google Maps
    |--------------------------------------------------------------------------
    |
    | En este valor se especifica el API KEY de Google Maps que usará el
    | aplicativo
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



    /*
    |--------------------------------------------------------------------------
    | Basic Auth
    |--------------------------------------------------------------------------
    |
    | En este valor se especifica el usuario de Basic Auth que usarán otras
    | aplicaciones para consumir servicios expuestos que usen dicho tipo de
    | autenticación
    */

    'basic_auth_usr' => env('BA_USER_APP_SUFIX'),
    'basic_auth_pwd' => env('BA_PASSWORD_APP_SUFIX'),



    /*
    |--------------------------------------------------------------------------
    | Zona de invitados
    |--------------------------------------------------------------------------
    |
    | En este valor se indica el nombre que tendrá la zona de invitados.
    | Considerar que el acceso a la zona de invitados por URL varia de 
    | acuerdo a cómo está instalada la aplicación:
    |
    |   https://misistema.cdmx.gob.mx/{guest_zone}
    |   https://subdominio.cdmx.gob.mx/mi-sistema/public/{guest_zone}
    |
    | El valor establecido en esta variable debe coincidir con la constante
    |
    |   App\Providers\RouteServiceProvider::HOME_INVITADO
    |
    | Ej. Si el nombre de la zona de invitados es "proveedores"
    | La constante deberá declararse como:
    |
    |   public const HOME_INVITADO = '/proveedores';
    */

    'guest_zone' => env('ZONA_INVITADOS_APP_SUFIX', 'invitados'),

];
