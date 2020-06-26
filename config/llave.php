<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Client ID
    |--------------------------------------------------------------------------
    |
    | Especificar en este atributo el ID de sistema proporcionado por el
    | administrador del sistema Llave
    |
    */

    'idcliente' => env('LLAVE_CLIENT_ID'),

    
    /*
    |--------------------------------------------------------------------------
    | Redirección al iniciar sesion
    |--------------------------------------------------------------------------
    |
    | En este valor se especifica la URL a la que direcciona el sistema llave
    | una vez que se lleve a cabo un inicio de sesión exitoso.
    |
    */

    'redirect' => env('LLAVE_URL_REDIRECT'),

    
    /*
    |--------------------------------------------------------------------------
    | Código Secreto
    |--------------------------------------------------------------------------
    |
    | En este atributo se especifica el código secreto proporcionado por el
    | administrador del sistema Llave.
    |
    */

    'secret' => env('LLAVE_APP_SECRET'),


    /*
    |--------------------------------------------------------------------------
    | Servicios Llave
    |--------------------------------------------------------------------------
    |
    | Estos atributos especifican end-points del sistema Llave, son los
    | mismos para cualquier sistema.
    |
    */

    'server' => env('LLAVE_SERVER'),

    'gettoken' => env('LLAVE_GET_TOKEN'),

    'getuser' => env('LLAVE_GET_USER'),

    'getroles' => env('LLAVE_GET_ROLES'),

    'createaccount' => env('LLAVE_CREATE_ACCOUNT'),

    /*
    |--------------------------------------------------------------------------
    | Auth Basic
    |--------------------------------------------------------------------------
    |
    | Atributos para especificar las credenciales de los servicios  Basic-Auth
    | de los end-points de Llave
    |
    */

    'domainuser' => env('LLAVE_DOMAIN_USER'),
    'domainpassword' => env('LLAVE_DOMAIN_PASSWORD'),

];
