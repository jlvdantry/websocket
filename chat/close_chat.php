<?php
if($_GET['id_op']!=-1){
	include_once('../adodb/adodb.inc.php');
	include_once('Sentencias.php');
	$query = new Sentencias();
	$db = $query->Iniciar_Transaccion($query);

	$sql = "update \"CHAT_OPERADORES\" set \"STATUS\"=0, \"SALIDA\"=LOCALTIMESTAMP, \"HOST\"='', \"NAVEGADOR\"='' where \"ID_OPERADOR\"=".$_GET['id_op'];
	$db->Execute($sql);

	$query->Finalizar_Transaccion($db);
}
?>
