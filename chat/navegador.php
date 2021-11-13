<?php
$tablet_browser = 0;
$mobile_browser = 0;
$body_class = 'desktop';

if (preg_match('/(tablet|ipad|playbook)|(android(?!.*(mobi|opera mini)))/i', strtolower($_SERVER['HTTP_USER_AGENT']))) {
    $tablet_browser++;
    $body_class = "tablet";
}

if (preg_match('/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone|android|iemobile)/i', strtolower($_SERVER['HTTP_USER_AGENT']))) {
    $mobile_browser++;
    $body_class = "mobile";
}

if ((strpos(strtolower($_SERVER['HTTP_ACCEPT']),'application/vnd.wap.xhtml+xml') > 0) or ((isset($_SERVER['HTTP_X_WAP_PROFILE']) or isset($_SERVER['HTTP_PROFILE'])))) {
    $mobile_browser++;
    $body_class = "mobile";
}

$mobile_ua = strtolower(substr($_SERVER['HTTP_USER_AGENT'], 0, 4));
$mobile_agents = array(
    'w3c ','acs-','alav','alca','amoi','audi','avan','benq','bird','blac',
    'blaz','brew','cell','cldc','cmd-','dang','doco','eric','hipt','inno',
    'ipaq','java','jigs','kddi','keji','leno','lg-c','lg-d','lg-g','lge-',
    'maui','maxo','midp','mits','mmef','mobi','mot-','moto','mwbp','nec-',
    'newt','noki','palm','pana','pant','phil','play','port','prox',
    'qwap','sage','sams','sany','sch-','sec-','send','seri','sgh-','shar',
    'sie-','siem','smal','smar','sony','sph-','symb','t-mo','teli','tim-',
    'tosh','tsm-','upg1','upsi','vk-v','voda','wap-','wapa','wapi','wapp',
    'wapr','webc','winw','winw','xda ','xda-');

if (in_array($mobile_ua,$mobile_agents)) {
    $mobile_browser++;
}

if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']),'opera mini') > 0) {
    $mobile_browser++;
    //Check for tablets on opera mini alternative headers
    $stock_ua = strtolower(isset($_SERVER['HTTP_X_OPERAMINI_PHONE_UA'])?$_SERVER['HTTP_X_OPERAMINI_PHONE_UA']:(isset($_SERVER['HTTP_DEVICE_STOCK_UA'])?$_SERVER['HTTP_DEVICE_STOCK_UA']:''));
    if (preg_match('/(tablet|ipad|playbook)|(android(?!.*mobile))/i', $stock_ua)) {
      $tablet_browser++;
    }
}
if ($tablet_browser > 0)
   $dispositivo = 'tablet';
else if ($mobile_browser > 0)
   $dispositivo = 'movil';
else
	$dispositivo = 'desktop';

$agente = $_SERVER['HTTP_USER_AGENT'];
$navegador = 'Unknown';
$platforma = 'Unknown';
$version= "";

//Obtenemos la Plataforma
if (preg_match('/Android/i', $agente)) {
	$datos = explode('Android ',$agente);
	$versiones = explode(';',$datos[1]);
	$platforma = 'Android '.str_replace(';','',$versiones[0]);
}
elseif (preg_match('/iphone/i', $agente)) {
	$datos = explode('iPhone OS ',$agente);
	$versiones = explode(' ',$datos[1]);
	$platforma = 'iPhone OS '.str_replace("_",".",$versiones[0]);
}
elseif (preg_match('/macintosh|mac os x/i', $agente)) {
	$platforma = 'Mac';
}
elseif (preg_match('/windows phone/i', $agente)) {
	$platforma = 'Windows Phone';
	$datos = explode('Windows Phone ',$agente);
	$versiones = explode(';',$datos[1]);
	$platforma = 'Windows Phone '.$versiones[0];
}
elseif (preg_match('/windows/i', $agente)) {
	$platforma = 'Windows';
	if(preg_match('/Windows NT/i', $agente)){
		$pdatos = explode('Windows NT ',$agente);
		$pversiones = explode(';',$pdatos[1]);
		if(count($pversiones)>1){
			$pversion = $pversiones[0];
		}else{
			$pdatos = explode('Windows NT ',$agente);
			$pversiones = explode(')',$pdatos[1]);
			$pversion = $pversiones[0];
		}

		if($pversion=="6.3")
			$pversion = " 8.1";
		else if($pversion=="6.2")
			$pversion = " 8";
		else if($pversion=="6.1")
			$pversion = " 7";
		else if($pversion=="6.0")
			$pversion = " Vista";
		else if($pversion=="5.2")
			$pversion = " XP x64";
		else if($pversion=="5.1")
			$pversion = " XP";
		else if($pversion=="5.0")
			$pversion = " 2000";
	}
	$platforma.=$pversion;
}
elseif (preg_match('/linux/i', $agente)) {
	$platforma = 'Linux';
}

//Obtener el UserAgente
if(preg_match('/like Gecko/i',$agente) && preg_match('/rv:11/i',$agente) || preg_match('/MSIE/i',$agente) && !preg_match('/Opera/i',$agente))
{
	$navegador = 'Internet Explorer';
	$navegador_corto = "IE";
	if($dispositivo=='movil'){
		$datos = explode('MSIE ',$agente);
		$versiones = explode(';',$datos[1]);
		$version = $versiones[0];
	}else{
		$datos = explode('rv:',$agente);
		$versiones = explode(')',$datos[1]);
		$version = $versiones[0];
		if($version==""){
			$datos = explode('MSIE ',$agente);
			$versiones = explode(';',$datos[1]);
			$version = $versiones[0];
		}
	}
}
elseif(preg_match('/Firefox/i',$agente))
{
	$navegador = 'Mozilla Firefox';
	$navegador_corto = "Firefox";
	$datos = explode('Firefox/',$agente);
	$version = $datos[1];
}
elseif(preg_match('/Opera/i',$agente) || preg_match('/OPR/i',$agente))
{
	$navegador = 'Opera';
	$navegador_corto = "Opera";
	if($dispositivo=='movil'){
		$agente =  eregi_replace("[\n|\r|\n\r]", ' ', $agente);
		$datos = explode('Opera Mini/',$agente);
		$versiones = explode('/',$datos[1]);
		$version = $versiones[0];
	}else{
		$datos = explode('OPR/',$agente);
		$version = $datos[1];
	}
}
elseif(preg_match('/CriOS/i',$agente))
{
	$navegador = 'Google Chrome';
	$navegador_corto = "Chrome";
	$datos = explode('CriOS/',$agente);
	$versiones = explode(' ',$datos[1]);
	$version = $versiones[0];
}
elseif(preg_match('/Chrome/i',$agente) || preg_match('/CriOS/i',$agente))
{
	if($dispositivo=='movil'){
		$navegador = 'Google Chrome';
		$navegador_corto = "Chrome";
		$datos = explode('CriOS/',$agente);
		$versiones = explode(' ',$datos[1]);
		$version = $versiones[0];
	}else{
		$navegador = 'Google Chrome';
		$navegador_corto = "Chrome";
		$datos = explode('Chrome/',$agente);
		$versiones = explode(' ',$datos[1]);
		$version = $versiones[0];
	}
}
elseif(preg_match('/Safari/i',$agente))
{
	$navegador = 'Apple Safari';
	$navegador_corto = "Safari";
	$datos = explode('Version/',$agente);
	$versiones = explode(' ',$datos[1]);
	$version = $versiones[0];
}
elseif(preg_match('/Netscape/i',$agente))
{
	$navegador = 'Netscape';
	$navegador_corto = "Netscape";
}

$agente =  preg_replace("[\n|\r|\n\r]", ' ', $agente);
$id_dispositivo = ($dispositivo=='desktop'?1:($dispositivo=='tablet'?2:($dispositivo=='movil'?3:0)));
/*$agente2 = str_replace('.','_',$agente2);
$agente2 = str_replace(';','_',$agente2);
$agente2 = str_replace('(','_',$agente2);
$agente2 = str_replace(')','_',$agente2);
$agente2 = str_replace('/','_',$agente2);
$agente2 = str_replace(':','_',$agente2);
echo $agente."<br />".$agente2."<br />".$navegador_corto."<br />".$version."<br />".$platforma."<br />".$dispositivo;*/

?>
