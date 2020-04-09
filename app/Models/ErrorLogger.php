<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ErrorLogger extends Model
{
    //
    protected $table = 't001803_error';
    protected $fillable =[
        'tx_uuid', 'tx_nivel', 'tx_detalle', 'tx_request_uri', 'tx_session_token', 'nu_http_response', 'idUsuario',
    ];

    
}
