<?php date_default_timezone_set('America/Mexico_City');
	$id = $_GET['id'];
	//header('Content-Type: text/html; charset=iso-8859-1');
	include_once('../adodb/adodb.inc.php');
	include_once('Sentencias.php');
	$query = new Sentencias();
	$db = $query->Iniciar_Transaccion($query);

	$sql = "update \"CHAT_AUTORIZACION\" set \"STATUS\"=0 where \"ID_CONVERSACION\" in(select \"ID_CONVERSACION\" from \"CHAT_CONVERSACIONES\" where \"ID_OPERADOR\"=".$id." and \"FIN\" is null)";
	$rs = $db->Execute($sql);
	
	$sql = "UPDATE \"CHAT_CONVERSACIONES\" SET \"FIN\"=LOCALTIMESTAMP where \"ID_OPERADOR\"=".$id." and \"FIN\" is null";
	$rs = $db->Execute($sql);

	$sql = "UPDATE \"CHAT_OPERADORES\" SET \"STATUS\"=4 where \"ID_OPERADOR\"=".$id;
	$rs = $db->Execute($sql);

	$query->Finalizar_Transaccion($db);
?>
