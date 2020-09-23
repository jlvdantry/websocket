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

    'idcliente' => env('LLAVE_CLIENT_ID_APP_SUFIX'),

    
    /*
    |--------------------------------------------------------------------------
    | Redirección al iniciar sesion
    |--------------------------------------------------------------------------
    |
    | En este valor se especifica la URL a la que direcciona el sistema llave
    | una vez que se lleve a cabo un inicio de sesión exitoso.
    |
    */

    'redirect' => env('LLAVE_URL_REDIRECT_APP_SUFIX'),

    
    /*
    |--------------------------------------------------------------------------
    | Código Secreto
    |--------------------------------------------------------------------------
    |
    | En este atributo se especifica el código secreto proporcionado por el
    | administrador del sistema Llave.
    |
    */

    'secret' => env('LLAVE_APP_SECRET_APP_SUFIX'),


    /*
    |--------------------------------------------------------------------------
    | Servicios Llave
    |--------------------------------------------------------------------------
    |
    | Estos atributos especifican end-points del sistema Llave, son los
    | mismos para cualquier sistema.
    |
    */

    'server' => env('LLAVE_SERVER_APP_SUFIX'),

    'gettoken' => env('LLAVE_GET_TOKEN_APP_SUFIX'),

    'getuser' => env('LLAVE_GET_USER_APP_SUFIX'),

    'getroles' => env('LLAVE_GET_ROLES_APP_SUFIX'),

    'createaccount' => env('LLAVE_CREATE_ACCOUNT_APP_SUFIX'),

    /*
    |--------------------------------------------------------------------------
    | Auth Basic
    |--------------------------------------------------------------------------
    |
    | Atributos para especificar las credenciales de los servicios  Basic-Auth
    | de los end-points de Llave
    |
    */

    'domainuser' => env('LLAVE_DOMAIN_USER_APP_SUFIX'),
    'domainpassword' => env('LLAVE_DOMAIN_PASSWORD_APP_SUFIX'),

];
