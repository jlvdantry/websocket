<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Archivo;
use App\AdipUtils\ArrrayList;

class Correo extends Model{

    public const NO_ENVIADO = 0;
    public const ENVIADO = 1;
    
    protected $table = 't001300_correo_app';
    protected $fillable= ['tx_from','tx_to','tx_cc','tx_cco','tx_subject', 'tx_body','nu_priority'];
    // protected $files = NULL;
    
    public function archivos(){
        return $this->belongsToMany(Archivo::class, 't001500_correo_archivo', 'id_correo','id_archivo');
    }

    public function withFiles(ArrayList $archivos){
        // TODO implementar este método
        throw new \Exception('No implementado');
    }
    
}
