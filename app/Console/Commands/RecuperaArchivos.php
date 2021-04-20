<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Archivo;
use App\AdipUtils\FileService;

class RecuperaArchivos extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'llave:recupera-archivos';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Genera una copia de los archivos del storage del arquetipo con sus nombres originales';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $pathPrefix = storage_path('app').DIRECTORY_SEPARATOR.FileService::STORAGE_FOLDER_NAME.DIRECTORY_SEPARATOR;
        $destPrefix = storage_path('app').DIRECTORY_SEPARATOR.FileService::STORAGE_FOLDER_NAME.'_original_names'.DIRECTORY_SEPARATOR;
        $archivaldos = Archivo::all(['tx_uuid','nb_archivo']);
        if(!is_dir($destPrefix)){
            mkdir($destPrefix);
            $this->comment('[ INFO ] Se creó la carpeta '.$destPrefix);
        }
        foreach($archivaldos as $archivaldo){
            if(file_exists($pathPrefix.$archivaldo->tx_uuid.'.dat')){
                if(copy (
                    $pathPrefix.$archivaldo->tx_uuid.'.dat'
                    ,$destPrefix.$archivaldo->nb_archivo )
                ){
                    $this->info('[ OK ] '. $archivaldo->tx_uuid.'dat ---> '.$archivaldo->nb_archivo);
                }else{
                    $this->comment('[ ! ] '. $archivaldo->tx_uuid.'dat ---> No se pudo generar la copia');
                }
            }else{
                $this->error('[ ! ] Error: '.$archivaldo->tx_uuid. ' este archivo no se encuentra');
            }
        }
        $this->comment('[ INFO ] Copia de archivos concluída. Consultar la carpeta '.$destPrefix.'');
    }
}
