<?php //session_start();
date_default_timezone_set('America/Mexico_City');
$st = $_GET['st'];
$op = $_GET['id_op'];
$conv = $_GET['conv'];
$id_institucion = $_GET['espera'];

include_once('../adodb/adodb.inc.php');
include_once('Sentencias.php');
$query = new Sentencias();
$db = $query->Iniciar_Transaccion($query);
if($st!=""){
	$sql = "update \"CHAT_OPERADORES\" set \"STATUS\"=".$st." where \"ID_OPERADOR\"=".$op;
	$db->Execute($sql);
}else{
	$sql = "select \"STATUS\" from \"CHAT_OPERADORES\"  where \"ID_OPERADOR\"=".$op;
	$rs = $db->Execute($sql);
	$st = $rs->fields[0];
	if($st==2 && $conv==""){
		/*if($op=="")
			$op = $_SESSION['id_operador'];*/

		/*$rs = $query->Consultar($query,"max(ID_CONVERSACION)","CHAT_CONVERSACIONES","ID_OPERADOR=".$op." AND FIN IS NULL","");*/
		//$sql = "select max(ID_CONVERSACION) from CHAT_CONVERSACIONES where ID_OPERADOR=".$op." AND FIN IS NULL";
		$sql = "select max(\"ID_CONVERSACION\") from \"CHAT_CONVERSACIONES\" where \"ID_OPERADOR\"=".$op." AND \"FIN\" IS NULL";
		$rs = $db->Execute($sql);
		$id_conversacion = $rs->fields[0];
		/*if($id_conversacion==0){
			$rs = $query->Consultar($query,"max(ID_CONVERSACION)","CHAT_CONVERSACIONES","ID_OPERADOR=".$op,"");
			$id_conversacion = $rs->fields[0];
		}*/
		echo "<input type='hidden' id='tconv_status' value='".$id_conversacion."' />";
	}
}

echo "<table><tr>";
if($st==2){
	if($conv=="")
		$tconv = $id_conversacion;
	else
		$tconv = $conv;

	//$sql = "select us.nombre from chat_conversaciones cnv, chat_usuarios us where cnv.ID_USUARIO = us.ID and cnv.ID_CONVERSACION=".$tconv;
	$sql = "select usu.\"NOMBRE\" from \"CHAT_CONVERSACIONES\" cnv, \"CHAT_USUARIOS\" usu where cnv.\"ID_USUARIO\" = usu.\"ID_USUARIO\" and  cnv.\"ID_CONVERSACION\" in(SELECT max(\"ID_CONVERSACION\") FROM \"CHAT_CONVERSACIONES\" WHERE \"ID_OPERADOR\"=".$op." and \"FIN\" IS NULL)";
	$rs = $db->Execute($sql);
	$usu_nom = trim($rs->fields[0]);
	$usu_nom = str_replace('@','_',$usu_nom);
	$usu_nom = str_replace(' ','_',$usu_nom);
	$usu_nom = str_replace('.','_',$usu_nom);
	$usu_nom = str_replace(',','_',$usu_nom);
	$usu_nom = str_replace('-','_',$usu_nom);
	$usu_nom = str_replace('á','a',$usu_nom);
	$usu_nom = str_replace('é','e',$usu_nom);
	$usu_nom = str_replace('í','i',$usu_nom);
	$usu_nom = str_replace('ó','o',$usu_nom);
	$usu_nom = str_replace('ú','u',$usu_nom);
	$usu_nom = str_replace('Á','A',$usu_nom);
	$usu_nom = str_replace('É','E',$usu_nom);
	$usu_nom = str_replace('Í','I',$usu_nom);
	$usu_nom = str_replace('Ó','O',$usu_nom);
	$usu_nom = str_replace('Ú','U',$usu_nom);
	$usu_nom = str_replace('ñ','n',$usu_nom);
	$usu_nom = str_replace('Ñ','N',$usu_nom);
	$usu_nom = preg_replace('/[^A-Za-z0-9\_]/', '', $usu_nom);

	echo "<td><input id='tusu_nom' type='hidden' value='$usu_nom' /></td>";
}
$sql = "select count(*) from \"CHAT_ESPERA\" where \"ID_INSTITUCION\"=".$id_institucion." and \"STATUS\"=1";
$rs = $db->Execute($sql);
$espera = $rs->fields[0];

echo ($espera>0?"<td style='width:60px'><img src='images/espera.png' class='parpadea' alt='Usuarios en Lista de Espera' title='Usuarios en Lista de Espera' /></td>":"")."<td><input type='hidden' id='tval' value='".$st."' /><a href='#' onclick='Cambiar_Status()'><img id='stat_opera' src='images/chat_".($st==1?"on":($st==2?"off":"pause")).".png' alt='".($st==1?"Disponible":($st==2?"No Disponible":"En Pausa"))."' title='".($st==1?"Disponible":($st==2?"No Disponible":"En Pausa"))."' /></a></td>";

echo "</tr></table>";
$query->Finalizar_Transaccion($db);
$db->Close();
?>
