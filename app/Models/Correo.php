<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Correo extends Model{

    public const NO_ENVIADO = 0;
    public const ENVIADO = 1;
    
    protected $table = 't001300_correo_app';
    protected $fillable= ['tx_from','tx_to','tx_cc','tx_cco','tx_subject', 'tx_body','nu_priority'];
    

    
}
