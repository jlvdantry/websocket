<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ErrorLogger extends Model
{
    /**
     * Nombre de la tabla asociada al modelo
     * 
     * @var String
     */
    protected $table = 't001803_error';

    
    /**
     * Nombres de columna que pueden ser asignados "En Masa"
     * 
     * @var Array
     */
    protected $fillable =[
        'tx_uuid', 'tx_nivel', 'tx_detalle', 'tx_request_uri', 'tx_session_token', 'nu_http_response', 'idUsuario',
    ];

    
}
