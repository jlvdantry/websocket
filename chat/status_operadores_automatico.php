<?php
	date_default_timezone_set('America/Mexico_City');

	$id_ins = $_GET['inst'];
	$pr = $_GET['perfil'];
	$criterio = ($pr!=4?"\"STATUS\">-1 AND \"PERFIL\"=1 AND \"ID_INSTITUCION\"=".$id_ins:"\"PERFIL\"<=3 and \"STATUS\">-1");
	include_once('../adodb/adodb.inc.php');
	include_once('Sentencias.php');
	$query = new Sentencias();
	$rs = $query->Consultar($query,"\"ID_OPERADOR\", \"STATUS\", \"ID_INSTITUCION\", \"PERFIL\"","\"CHAT_OPERADORES\"",$criterio,"\"STATUS\" DESC, \"ID_INSTITUCION\", \"PERFIL\", \"ID_OPERADOR\"");
	while(!$rs->EOF){
		$cadena = ($cadena==""?$rs->fields['ID_OPERADOR']."@".$rs->fields['STATUS']."@".$rs->fields['ID_INSTITUCION']."@".$rs->fields['PERFIL']:$cadena."|".$rs->fields['ID_OPERADOR']."@".$rs->fields['STATUS']."@".$rs->fields['ID_INSTITUCION']."@".$rs->fields['PERFIL']);
		$rs->MoveNext();
	}
	echo $cadena;
?>
