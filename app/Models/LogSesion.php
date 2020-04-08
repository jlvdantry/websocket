<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogSesion extends Model
{
    //
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
