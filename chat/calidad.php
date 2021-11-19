<?php
include_once('../adodb/adodb.inc.php');
include_once('Sentencias.php');
$query = new Sentencias();

$rs = $query->Consultar($query,"CASE WHEN cnv.ID_ESPERA>0 THEN cnv.INICIO-esp.ENTRADA ELSE null END as ESPERA","CHAT_CONVERSACIONES cnv, CHAT_ESPERA esp","cnv.ID_ESPERA = esp.ID_ESPERA AND cnv.ID_CONVERSACION=".$_POST['conv'],"");
//$rs = $query->Consultar($query,"cnv.dispositivo as DISPOSITIVO, cnv.SO as SO, cnv.navegador || ' ' || cnv.version as NAVEGADOR, cnv.TEMA as TEMA, CASE WHEN cnv.ID_ESPERA>0 THEN cnv.INICIO-esp.ENTRADA ELSE null END as ESPERA","CHAT_CONVERSACIONES cnv, CHAT_ESPERA esp","cnv.ID_ESPERA = esp.ID_ESPERA AND cnv.ID_CONVERSACION=".$_POST['conv'],"");
if($rs->fields['ESPERA']!=""){
	$time = $rs->fields['ESPERA'];
	$time = str_replace('+000000000 ','',$time);
	$time_split = explode('.',$time);
	$time = $time_split[0];
}

$time = ($time!=""?$time:"");
if($time!=""){
	echo "<table class='tabla'>";//style='color:#5a5a5a; width:200px;margin:10px 10px;'
	echo "<tr><td class='tabla_cabecera'>Tiempo en Espera</td></tr>";
	echo "<tr style='color:#BF1E2E' align='center'><td><strong>".$time."</strong></td></tr>";
	echo "</table>";
}

/*$temas = array("","Denuncia","Emergencia","Seguimiento","Solicitud de Informaci&oacute;n","Tr&aacute;mites");
$dispositivo = array("","Desktop","Tablet","Movil");
echo "<table class='tabla'>";//style='color:#5a5a5a; width:200px;margin:10px 10px;'
echo "<tr><td class='tabla_cabecera' colspan='2'>Datos del Usuario</td></tr>";
echo "<tr><td><strong>S.O.:</strong></td><td>".$rs->fields['SO']."</td></tr>";
echo "<tr><td><strong>Dispositivo:</strong></td><td>".$dispositivo[$rs->fields['DISPOSITIVO']]."</td></tr>";
echo "<tr><td><strong>Navegador:</strong></td><td>".$rs->fields['NAVEGADOR']."</td></tr>";
echo ($time!=""?"<tr style='color:#BF1E2E'><td><strong>Espera:</strong></td><td><strong>".$time."</strong></td></tr>":"");
echo "<tr><td><strong>Tema:</strong></td><td>".$temas[$rs->fields['TEMA']]."</td></tr>";
echo "<tr><td>Sub-Tema:</td><td></td></tr>";
echo "<tr><td>Asunto:</td><td></td></tr>";
echo "</table>";*/ //Esto esta comentado, no hace nada...

$rs->Close();
//$db->Close(); //este es el error "Call to a member function Close() on a non-object in.. on line 33",
				//si manda en los log de "c:/wamp/logs/php_error.log" en la linea "36", comentarla tambien...
?>
