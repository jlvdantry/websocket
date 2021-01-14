<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MetaController extends Controller
{
    /**
     * Devuelve el contenido del archivo robots.txt
     * 
     * @see https://developers.google.com/search/docs/advanced/robots/intro?hl=es
     * @param void
     * @return \Illuminate\Http\Response
     */
    public function getRobotsFile(){
        $p = resource_path('engine'.DIRECTORY_SEPARATOR.'meta'.DIRECTORY_SEPARATOR.'robots.txt');
        return response()->file($p);
    }


    /**
     * Devuelve el contenido del archivo humans.txt
     * 
     * @see http://humanstxt.org/ES
     * @param void
     * @return \Illuminate\Http\Response
     */
    public function getHumansFile(){
        $p = resource_path('engine'.DIRECTORY_SEPARATOR.'meta'.DIRECTORY_SEPARATOR.'humans.txt');
        return response()->file($p);
    }

    /**
     * Devuelve el contenido del archivo security.txt
     * 
     * @see https://securitytxt.org/
     * @param void
     * @return \Illuminate\Http\Response
     */
    public function getSecurityFile(){
        $p = resource_path('engine'.DIRECTORY_SEPARATOR.'meta'.DIRECTORY_SEPARATOR.'security.txt');
        $content = file_get_contents($p);
        $content = preg_replace('/%APPNAME%/',config('app.name'), $content);
        return response($content)->header('Content-Type', 'text/plain');
        return response()->file($p);
    }
}
