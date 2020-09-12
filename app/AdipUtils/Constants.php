<?php

namespace App\AdipUtils;

final class Constants{

    /**
     * Desactivar instanciación de clase
     */
    private function __construct(){}
    
    // Status
    public const ACTIVO = 1;
    public const NO_ACTIVO = 2;

    // Paginador
    public const RESULTS_PER_PAGE = 15;

    /**
     * Devuelve una representació de texto correspondiente
     * al mes dado por $m
     * 
     * @param int
     * @return String
     */
    public static function mes($m):String{
        $m=(int)$m;
        $m=$m>12?0:$m;
        $m=$m<0?0:$m;
        $meses =[
            '','Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre',
        ];
        return $meses[$m];
    }
	


}
