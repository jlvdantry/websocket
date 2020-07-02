<?php

namespace App\Http\Controllers\AdipServices;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\AdipUtils\FileService;


class StorageController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
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
        return response()->file($file->real_path);
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
          return response()->download($file->real_path, $file->archivo->nb_archivo, ['Content-Type' => $file->archivo->tx_mime_type]);
    }

}