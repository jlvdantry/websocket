<?php
$from = $_POST['de'];
$to = $_POST['para'];
$id_conversacion = $_POST['cve'];
$id_operador = $_POST['op'];
$id_institucion = $_POST['inst'];

include_once('../adodb/adodb.inc.php');
include_once('Sentencias.php');
$query = new Sentencias();
$db = $query->Iniciar_Transaccion($query);
$sql = "update CHAT_OPERADORES set STATUS=3 WHERE ID_OPERADOR=".$id_operador;
$db->Execute($sql);

$sql = "UPDATE CHAT_AUTORIZACION SET STATUS=1,ID_CONVERSACION=NULL,ID_ESPERA=NULL WHERE ID_CONVERSACION=".$id_conversacion;
$db->Execute($sql);
	
	$rs_estatus = $query->Consultar($query,"*","(SELECT ID_OPERADOR, PSEUDONIMO FROM CHAT_OPERADORES WHERE STATUS=1 and PERFIL=1 AND ID_INSTITUCION=".$id_institucion." ORDER BY dbms_random.value)","rownum = 1","");
	if($rs_estatus->RecordCount()>0){		
		$id_operador_new = $rs_estatus->fields['ID_OPERADOR'];
		$pseudonimo_new = $rs_estatus->fields['PSEUDONIMO'];
		$sql = "UPDATE CHAT_OPERADORES SET STATUS=2 WHERE ID_OPERADOR=".$id_operador_new;
		$db->Execute($sql);
		
		$sql = "update CHAT_CONVERSACIONES set TRANSFER=1, ID_INSTITUCION=".$id_institucion.", ID_OPERADOR=".$id_operador_new." where ID_CONVERSACION=".$id_conversacion;
		$db->Execute($sql);
				
		$sql = "SELECT SEQ_CHAT_ID_MENSAJE.NEXTVAL FROM DUAL";
		$rs = $db->Execute($sql);
		$id_mensaje = $rs->fields[0];
		
		$sql = "insert into CHAT_MENSAJES_NEW(ID_MENSAJE_NEW,FROMM,TOO,MESSAGE,SENT,ID_CONVERSACION,RECD) values (".$id_mensaje.",'".$to."', '".$pseudonimo_new."','Usuario Transferido',LOCALTIMESTAMP,".$id_conversacion.",0)";		
		$db->Execute($sql);
	}else{
		$sql = "update CHAT_CONVERSACIONES set FIN=LOCALTIMESTAMP,TRANSFER=2, ID_INSTITUCION=".$id_institucion." where ID_CONVERSACION=".$id_conversacion;
		$db->Execute($sql);
		
		$sql = "SELECT SEQ_CHAT_ID_MENSAJE.NEXTVAL FROM DUAL";
		$rs = $db->Execute($sql);
		$id_mensaje = $rs->fields[0];
		
		$sql = "insert into CHAT_MENSAJES_NEW(ID_MENSAJE_NEW,FROMM,TOO,MESSAGE,SENT,ID_CONVERSACION,RECD) values (".$id_mensaje.",'".$from."', '".$to."','Usuario Transferido a Lista de Espera',LOCALTIMESTAMP,".$id_conversacion.",1)";
		$db->Execute($sql);
		
		$sql = "SELECT SEQ_CHAT_ID_MENSAJE.NEXTVAL FROM DUAL";
		$rs = $db->Execute($sql);
		$id_mensaje = $rs->fields[0];
		
		$sql = "insert into CHAT_MENSAJES_NEW(ID_MENSAJE_NEW,FROMM,TOO,MESSAGE,SENT,ID_CONVERSACION,RECD) values (".$id_mensaje.",'".$from."', '".$to."','Sesion terminada por el operador',LOCALTIMESTAMP,".$id_conversacion.",1)";
		$db->Execute($sql);
	}

if($query->Finalizar_Transaccion($db)){
	$rs->Close();
	$db->Close();
	echo 1;
}else 
	echo 0;
?>