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
    public function getFileByUuid(Request $r, $uuid){
		return FileService::getFile($uuid);
    }

    /**
     * Forzar descarga de archivo por Uuid
     * 
     * @param  \Illuminate\Http\Request  $r
     * @param String $uuid
     * @return \Illuminate\Http\Response
     */
    public function downloadFileByUuid(Request $r){
		return FileService::getFile($uuid, TRUE);
    }

}
