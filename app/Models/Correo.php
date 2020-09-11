<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Archivo;
use App\AdipUtils\ArrayList;
use App\AdipUtils\FileService;

class Correo extends Model{

    /**
     * Constantes del modelo
     */
    public const NO_ENVIADO = 0;
    public const ENVIADO = 1;


    /**
     * Nombre de la tabla asociada al modelo
     * 
     * @var String
     */
    protected $table = 't001300_correo_app';


    /**
     * Nombres de columna que pueden ser asignados "En Masa"
     * 
     * @var Array
     */
    protected $fillable= ['tx_from','tx_to','tx_cc','tx_cco','tx_subject', 'tx_body','nu_priority'];


    /**
     * Mutator para columnas de fecha
     * 
     * @var Array
     */
    protected $dates = ['fh_proximo_intento'];

    
    /**
     * Relacion con archivos (many to many)
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function archivos(){
        return $this->belongsToMany(Archivo::class, 't001500_correo_archivo', 'id_correo','id_archivo');
    }


    /**
     * Adjunta un archivo o archivos a un correo
     * 
     * @param \SplFileInfo|ArrayList|Archivo $archivos 
     * @return void
     * @throws \Exception
     */
    public function withFiles($archivos){
        if($archivos instanceof ArrayList){
            // Revisar si los elementos son instancias de
            // Archivo o SplFileInfo
            for($a = 0; $a < $archivos->size(); $a++){
                $archivaldo = $archivos->getItem($a);
                if(!($a instanceof \SplFileInfo) && !($a instanceof Archivo)){
                    throw new \Exception('Las instancias de $archivos deben ser una instancia de SplFileInfo o Archivo');
                }
            }
            // Todos son instancias válidas, adjuntar
            for($a = 0; $a < $archivos->size(); $a++){
                $archivaldo = $archivos->getItem($a);
                $this->adjuntar($archivaldo);
            }
        }else{
            $this->adjuntar($archivos);
        }
    }

    
    /**
     * Adjunta un archivo
     * 
     * @param \SplFileInfo|Archivo
     * @return void
     * @throws \Exception
     */
    private function adjuntar($a){
        if($a instanceof \SplFileInfo){
            $res = FileService::addToStorage($a);
            $this->archivos()->attach($res->id);
        }elseif($a instanceof Archivo){
            $this->archivos()->attach($a->id);
        }else{
            throw new \Exception('$a debe ser una instancia de SplFileInfo o Archivo');
        }
    }
    
}
