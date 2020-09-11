<?php

namespace App\Models;
//use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
//use Illuminate\Notifications\Notifiable;
//use App\Auth\NoRememberTokenAuthenticable;
use App\Models\Permiso;
use \Arr;

use Illuminate\Database\Eloquent\Model;

class ApiApp extends Authenticatable
{
    /**
     * Desactivar campos created_at y updated_at
     * 
     * @var bool
     */
    public $timestamps = FALSE;


    /**
     * Establecer la clave primaria del modelo
     * 
     * @var String
     */
    protected $primaryKey = 'id';


    /**
     * Nombre de la tabla asociada al modelo
     * 
     * @var String
     */
    protected $table = 'apps_api';


    /**
     * Nombres de columna que se ocultan al hacer 
     * conversion a JSON o Array
     * 
     * @var Array
     */
    protected $hidden = ['created_at', 'updated_at', 'api_token'];

    
    /**
     * Nombres de columna que pueden ser asignados "En Masa"
     * 
     * @var Array
     */
    protected $fillable = [
        'nb_aplicacion'
        ,'tx_descripcion_app'
        ,'api_token'
        ,'st_activo'
        ,'created_at'
        ,'updated_at'
    ];
    
}

