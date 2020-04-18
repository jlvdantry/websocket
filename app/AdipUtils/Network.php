<?php

namespace App\AdipUtils;

final class Network{
		
	private function __construct() { ; }
	
    /**
     * getClientIP
     * Devuelve la dirección IP del cliente
     * @return string
     **/
    public static function getClientIP():String{
		if (isset($_SERVER['HTTP_CLIENT_IP']))
			$ipaddress = $_SERVER['HTTP_CLIENT_IP'];
		else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
			$ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
		else if(isset($_SERVER['HTTP_X_FORWARDED']))
			$ipaddress = $_SERVER['HTTP_X_FORWARDED'];
		else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
			$ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
		else if(isset($_SERVER['HTTP_FORWARDED']))
			$ipaddress = $_SERVER['HTTP_FORWARDED'];
		else if(isset($_SERVER['REMOTE_ADDR']))
			$ipaddress = $_SERVER['REMOTE_ADDR'];
		else
			$ipaddress = 'UNKNOWN';
		return $ipaddress;
	}
    
    /**
     * getClientUA
     * Devuelve la cadena de identificación del agente de usuario
     * @return string
     **/
	public static function getClientUA():String{
		if(!isset($_SERVER['HTTP_USER_AGENT'])) return 'NONE';
		$ret=strlen(trim($_SERVER['HTTP_USER_AGENT']))>0?$_SERVER['HTTP_USER_AGENT']:'NONE';
		return $ret;
	}
    
    /**
     * getClientMAC
     * Devuelve la dirección física de un equipo de red dada la IP del mismo
     * Solo funciona para equipos que se envuentren en el mismo segmento de la red
     * @pre-requisites: Función shell_exec() habilitada
     * @return string Dirección MAC del cliente o 00:00:00:00:00:00 si algo sale mal
     **/
	public static function getClientMAC():String{
		$mac=shell_exec("arp -a ".Network::getClientIP());
		preg_match('/..[:-]..[:-]..[:-]..[:-]..[:-]../', $mac, $matches);
		$realMac=$matches[0]===NULL?'00:00:00:00:00:00':$matches[0];
		return strtoupper($realMac);
	}

    /**
     * getClientOS
     * Intenta obtener el sistema operativo del cliente a traves de la cadena
	 * User-Agent
     * @return string Nombre del sistema operativo
     **/
	public static function getClientOS($ua=''):String{
		$ua=$ua==''?self::getClientUA():$ua;
		$ret='Otro';
		$patterns=[];
		$patterns[]=['patt'=>'/Win16/', 'os' =>'Windows 3.11'];
		$patterns[]=['patt'=>'/(Windows 95)|(Win95)|(Windows_95)/', 'os' =>'Windows 95'];
		$patterns[]=['patt'=>'/(Windows 98)|(Win98)/', 'os' =>'Windows 98'];
		$patterns[]=['patt'=>'/(Windows NT 5.0)|(Windows 2000)/', 'os' =>'Windows 2000'];
		$patterns[]=['patt'=>'/(Windows NT 5.1)|(Windows XP)/', 'os' =>'Windows XP'];
		$patterns[]=['patt'=>'/(Windows NT 5.2)/', 'os' =>'Windows Server 2003'];
		$patterns[]=['patt'=>'/(Windows NT 6.0)/', 'os' =>'Windows Vista'];
		$patterns[]=['patt'=>'/(Windows NT 6.1)/', 'os' =>'Windows 7'];
		$patterns[]=['patt'=>'/(Windows NT 6.2)/', 'os' =>'Windows 8'];
		$patterns[]=['patt'=>'/(Windows NT 10.0)/', 'os' =>'Windows 10'];
		$patterns[]=['patt'=>'/(Windows NT 4.0)|(WinNT4.0)|(WinNT)|(Windows NT)/', 'os' =>'Windows NT 4.0'];
		$patterns[]=['patt'=>'/Windows ME/', 'os' =>'Windows ME'];
		$patterns[]=['patt'=>'/OpenBSD/', 'os' =>'Open BSD'];
		$patterns[]=['patt'=>'/SunOS/', 'os' =>'Sun OS'];
		$patterns[]=['patt'=>'/(Android)/', 'os' =>'Android'];
		$patterns[]=['patt'=>'/(Linux)|(X11)/', 'os' =>'Linux'];
		$patterns[]=['patt'=>'/(Mac_PowerPC)|(Macintosh)/', 'os' =>'Mac OS'];
		$patterns[]=['patt'=>'/QNX/', 'os' =>'QNX'];
		$patterns[]=['patt'=>'/BeOS/', 'os' =>'BeOS'];
		$patterns[]=['patt'=>'/OS\/2/', 'os' =>'OS/2'];
		$patterns[]=['patt'=>'/(nuhk)|(Googlebot)|(Yammybot)|(Openbot)|(Slurp)|(MSNBot)|(Ask Jeeves\/Teoma)|(ia_archiver)/', 'os' =>'Bot de búsqueda'];
		// für ADIP
		$patterns[]=['patt'=>'/(ADIP\/CDMX)/', 'os' =>'ADIP - Cliente API mediciones Alameda Central'];

		for($p=0;$p<count($patterns);$p++){
			if(preg_match($patterns[$p]['patt'],$ua)){
				$ret = $patterns[$p]['os'];
				break;
			}
		}
		return ($ret);
	}
	
}