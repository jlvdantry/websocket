<?php

namespace App\Http\Controllers\AdipServices;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\AdipUtils\FileService;


class StorageController extends Controller
{
    public function __construct(){
        $this->middleware('auth')->except(['showPublicFileByUuid']);
    }

    /**
     * Obtiene archivo por Uuid
     * 
     * @param  \Illuminate\Http\Request  $r
     * @param String $uuid
     * @return \Illuminate\Http\Response
     */
    public function showFileByUuid(Request $r, $uuid){
        $file =  FileService::getFile($uuid);
        if($this->authorizeFile($file)){
            return response()->file($file->real_path, ['Content-Type' => $file->archivo->tx_mime_type]);
        }
        abort(403, 'No tienes permisos para ver este recurso');
    }

    /**
     * Obtiene archivo por Uuid sin autenticar
     * 
     * @param  \Illuminate\Http\Request  $r
     * @param String $uuid
     * @return \Illuminate\Http\Response
     */
    public function showPublicFileByUuid(Request $r, $uuid){
        $file =  FileService::getPublicFile($uuid);
        if($this->authorizeFile($file)){
            return response()->file($file->real_path, ['Content-Type' => $file->archivo->tx_mime_type]);
        }
        abort(403, 'No tienes permisos para ver este recurso');
    }

    /**
     * Forzar descarga de archivo por Uuid
     * 
     * @param  \Illuminate\Http\Request  $r
     * @param String $uuid
     * @return \Illuminate\Http\Response
     */
    public function downloadFileByUuid(Request $r, $uuid){
          $file =  FileService::getFile($uuid);
          if($this->authorizeFile($file)){
            return response()->download($file->real_path, $file->archivo->nb_archivo, ['Content-Type' => $file->archivo->tx_mime_type]);
          }
          abort(403, 'No tienes permisos para ver este recurso');
    }


    /**
     * Determina si el usuario actual puede o no
     * ver el archivo. Este método debe realizar
     * cualquier validación que retorne TRUE o FALSE
     * 
     * @param  Object El archivo que se desea evaluar
     * @return bool
     */
    private function authorizeFile(Object $theFile):bool{
        // Ejemplo de autorizacion para ver el archivo:
        // Para archivos públicos negar el acceso al
        // navegador Yandex y para los archivos
        // no públicos se debe tener el rol ROL_DEMO
        /*
        if($theFile->archivo->st_public === 1){
            return !(bool)stripos(\App\AdipUtils\Network::getClientUA(),'yowser');
        }else{
            if(\Auth::check()){
                return \Auth::user()->hasRole(\App\Models\Permiso::ROL_DEMO);
            }
            return FALSE;
        }
        */
        
        // De manera predeterminada, la autorización está activada
        return TRUE;
    }


}
