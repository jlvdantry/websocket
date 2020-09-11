<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LlaveSesion extends Model{

    /**
     * Constantes del modelo
     */
    public const OPEN   = 1;
    public const CLOSED = 0;


    /**
     * Desactivar campos created_at y updated_at
     * 
     * @var bool
     */
    public $timestamps = false;
    protected $table='t001800_sesion';

    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tx_code', 'tx_token', 'ix_token', 'id_usuario', 'tx_user_agent', 'tx_ip', 'tx_stamp_inicia', 'tx_stamp_caduca', 'st_abierta', 'fh_registra'
    ];

}
