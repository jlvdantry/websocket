<?php
date_default_timezone_set('America/Mexico_City');
$id_cnv = $_POST['conversacion'];
$msg = $_POST['msg'];

if($id_cnv!="" && $msg!=""){
	include_once('../adodb/adodb.inc.php');
	include_once('Sentencias.php');
	$query = new Sentencias();

	$db = $query->Iniciar_Transaccion($query);
	$sql = "UPDATE \"CHAT_CONVERSACIONES\" SET \"$msg\"=LOCALTIMESTAMP WHERE \"ID_CONVERSACION\"=$id_cnv";
	$rs2 = $db->Execute($sql);
	$query->Finalizar_Transaccion($db);
	$db->Close();
}
?>
