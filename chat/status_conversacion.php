<?php //session_start();
date_default_timezone_set('America/Mexico_City');
if($_POST['conversacion']!=""){
	include_once('../adodb/adodb.inc.php');
	include_once('Sentencias.php');
	$query = new Sentencias();
	$db = $query->Iniciar_Transaccion($query);
	$sql = "SELECT \"TRANSFER\", \"ID_OPERADOR\", \"ID_INSTITUCION\" FROM \"CHAT_CONVERSACIONES\" where \"ID_CONVERSACION\"=".$_POST['conversacion'];
	$rs = $db->Execute($sql);
	if($rs->fields[0]==1){//Transferencia
		$sql = "update chat_conversaciones set transfer=0 where ID_CONVERSACION=".$_POST['conversacion'];
		$db->Execute($sql);

		$sql = "select ID_OPERADOR, PSEUDONIMO from chat_operadores where ID_OPERADOR=".$rs->fields['ID_OPERADOR'];
		$rs_op = $db->Execute($sql);
		
		if($_POST['tkn']!=""){
			$sql = "UPDATE CHAT_AUTORIZACION SET STATUS=2,ID_CONVERSACION=".$_POST['conversacion']." WHERE TOKEN='".$_POST['tkn']."'";
			$db->Execute($sql);
		}
	}elseif($rs->fields[0]==2){//Transferencia->Lista de Espera
			$ip = $_SERVER['REMOTE_ADDR'];

			$sql = "update chat_conversaciones set transfer=3 where ID_CONVERSACION=".$_POST['conversacion'];
			$db->Execute($sql);

			$sql = "SELECT SEQ_CHAT_ID_ESPERA.NEXTVAL FROM DUAL";
			$rs_espera = $db->Execute($sql);
			$id_espera = $rs_espera->fields[0];

			$sql = "insert into CHAT_ESPERA(ID_ESPERA,NOMBRE,CORREO,IP,ENTRADA,ATENCION,STATUS,ID_INSTITUCION) values(".$id_espera.",'".$_POST['nombre']."','".$_POST['correo']."','".$ip."',LOCALTIMESTAMP, LOCALTIMESTAMP,1,".$rs->fields['ID_INSTITUCION'].")";
			$db->Execute($sql);
			
			if($_POST['tkn']!=""){
				$sql = "UPDATE CHAT_AUTORIZACION SET STATUS=2,ID_ESPERA=".$id_espera." WHERE TOKEN='".$_POST['tkn']."'";
				$db->Execute($sql);
			}
	}

	if($query->Finalizar_Transaccion($db)){
		if($rs->fields[0]==1)
			echo $rs->fields['TRANSFER']."|".$rs_op->fields['PSEUDONIMO']."|".$rs->fields['ID_INSTITUCION'];
		else if($rs->fields[0]==2)
			echo $rs->fields['TRANSFER']."|<input type='hidden' id='id_espera' value='".$id_espera."'><img src='chat/images/load_chat.gif' border='0' /><br />Gracias por usar el servicio<br />de Chat de Locatel,<br />por favor permanezca en l&iacute;nea,<br />en un momento le atenderemos.|".$rs->fields['ID_INSTITUCION'];
		else
			echo $rs->fields['TRANSFER'];
	}
}else{
	$us = trim($_POST['us']);
	$us = str_replace('@','_',$us);
	$us = str_replace(' ','_',$us);
	$us = str_replace('.','_',$us);
	$us = str_replace(',','_',$us);
	$us = str_replace('-','_',$us);
	//$_SESSION['username'] = $us;
	echo "-1";
}
?>
