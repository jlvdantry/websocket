<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Archivo;
use App\AdipUtils\ArrrayList;
use App\AdipUtils\FileService;

class Correo extends Model{

    public const NO_ENVIADO = 0;
    public const ENVIADO = 1;
    
    protected $table = 't001300_correo_app';
    protected $fillable= ['tx_from','tx_to','tx_cc','tx_cco','tx_subject', 'tx_body','nu_priority'];
    // protected $files = NULL;
    
    public function archivos(){
        return $this->belongsToMany(Archivo::class, 't001500_correo_archivo', 'id_correo','id_archivo');
    }

    public function withFiles($archivos){
        if($archivos instanceof ArrayList){
            for($a = 0; $a < $archivos->size(); $a++){
                $archivaldo = $archivos->getItem($a);
                $this->adjuntar($a);
            }
        }else{
            $this->adjuntar($archivos);
        }
    }

    private function adjuntar($a){
        if($a instanceof \SplFileInfo){
            $res = FileService::addToStorage($a);
            $this->archivos()->attach($res->id);
        }elseif($a instanceof Archivo){
            $this->archivos()->attach($a->id);
        }else{
            throw new \Exception('$archivos debe ser una instancia de SplFileInfo o Archivo o ArrayList con elementos Archivo / SplFileInfo');
        }
    }
    
}
