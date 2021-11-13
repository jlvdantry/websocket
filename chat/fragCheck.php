<?php
include_once('../adodb/adodb.inc.php');
include_once('Sentencias.php');
$query = new Sentencias();
$query->Conectar();
//$rs = $query->chkFrag($query);
//$rs = $query->desFrag($query, ??,"CHAT_CONVERSACIONES cnv, CHAT_ESPERA esp") //desFrag(db,campoID,tabla)
?>