<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Archivo extends Model
{
    protected $table = 't001301_archivo_app';

    protected $fillable = [
        'nb_archivo'
        ,'tx_mime_type'
        ,'nu_tamano'
        ,'tx_uuid'
        ,'tx_sha256'
        ,'usr_alta'
    ];

    protected $hidden = [
        'tx_uuid'
        ,'tx_sha256'
    ];

    protected $dates = [
        'fh_alta'
        ,'fh_borrado'
    ];

}
