<?php
date_default_timezone_set('America/Mexico_City');
$id_cnv = $_POST['conversacion'];
$msg = $_POST['msg'];
if($id_cnv!="" && $msg!=""){
	include_once('../adodb/adodb.inc.php');
	include_once('Sentencias.php');
	$query = new Sentencias();
	$rs = $query->Consultar($query,"60*(60*(24*(LOCALTIMESTAMP-\"".$msg."\")))","\"CHAT_CONVERSACIONES\"","\"ID_CONVERSACION\"=$id_cnv","");
	if($rs->fields[0]!=""){
		$datos = explode(" ",$rs->fields[0]);
		echo (int)str_replace("+","",$datos[0]);
	}else
		echo "esperando...";
}else
	echo "esperando...";
?>
