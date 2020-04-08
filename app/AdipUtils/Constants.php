<?php

namespace App\AdipUtils;

final class Constants{

    private function __construct(){}
    
    // Status
    public const ACTIVO = 1;
    public const NO_ACTIVO = 2;

    // Paginador
    public const RESULTS_PER_PAGE = 15;

    public static function mes($m){
        $m=(int)$m;
        $meses =[
            '','Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre',
        ];
        return $meses[$m];
    }
	


}