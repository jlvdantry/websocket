<?php	$cve = $_POST['cve'];	
	include_once('../adodb/adodb.inc.php');
	include_once('Sentencias.php');
	$query = new Sentencias();	
	$rs = $query->Consultar($query,"STATUS","CHAT_OPERADORES","ID_OPERADOR=".$cve,"");	
	echo $rs->fields[0];
?>