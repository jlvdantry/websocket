<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogSesion extends Model
{
    /**
     * Desactivar campos created_at y updated_at
     * 
     * @var bool
     */
    public $timestamps = false;
    protected $table='t001801_sesion_log';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'ix_token', 'tx_mensaje', 'fh_registra'
    ];
}
