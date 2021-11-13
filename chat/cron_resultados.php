<?php
	include_once('../adodb/adodb.inc.php');
	include_once('Sentencias.php');
	$query = new Sentencias();
	$db = $query->Iniciar_Transaccion($query);

	//$sql = "SELECT count(*) FROM conversaciones cnv, chat ct WHERE cnv.id_conversacion = ct.id_conversacion AND ct.recd=0 AND cnv.fin!='0000-00-00 00:00:00'";
	$sql = "SELECT count(*) FROM CHAT_CONVERSACIONES cnv, CHAT_MENSAJES ct WHERE cnv.ID_CONVERSACION = ct.ID_CONVERSACION AND ct.RECD=0 AND cnv.FIN is not null AND ct.message<>'Sesion terminada por el usuario'";
	$rs = $db->Execute($sql);
	$conv = $rs->fields[0];
	if($conv>0){
		//$sql = "update chat set recd=1 where id in(SELECT id FROM (SELECT ct.id FROM conversaciones cnv, chat ct WHERE cnv.id_conversacion = ct.id_conversacion AND ct.recd = 0 AND cnv.fin!='0000-00-00 00:00:00') AS tmptable)";
		$sql = "update CHAT_MENSAJES set RECD=1 where ID in(SELECT ct.ID FROM CHAT_CONVERSACIONES cnv, CHAT_MENSAJES ct WHERE cnv.ID_CONVERSACION = ct.ID_CONVERSACION AND ct.RECD = 0 AND cnv.FIN is not null AND ct.message<>'Sesion terminada por el usuario')";
		$db->Execute($sql);
	}
	$query->Finalizar_Transaccion($db);
	$db->Close();
	$valor = date('d-m-Y H:i:s')." Conversaciones Colgadas: ".$conv;
	echo $valor."<br />";
	/*$fp = fopen('data.txt', 'a');
	fwrite($fp, $valor."\r\n");
	fclose($fp);*/
?>