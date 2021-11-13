<?php date_default_timezone_set('America/Mexico_City');
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

include_once('../adodb/adodb.inc.php');
include_once('Sentencias.php');

$query = new Sentencias();

if ($_POST['action'] == "chatheartbeat") { //***********************Recibir Mensajes********************//
	$to = $_POST['un'];
	$id_cnv = $_POST['id_conv'];
	$umsg = $_POST['ult_msg'];
	
	if($to=="") exit();
		
	$cadena="";
	$message="";
	
	$db = $query->Iniciar_Transaccion($query);
	$sql = "SELECT \"ID_MENSAJE_NEW\",\"MESSAGE\" FROM \"CHAT_MENSAJES_NEW\" WHERE \"TOO\"='".addslashes($to)."' AND \"RECD\" = 0 ".($id_cnv!=""?" AND \"ID_CONVERSACION\"=".$id_cnv:"")." AND TO_CHAR(\"SENT\",'yyyy-mm-dd')='".date('Y-m-d')."' order by \"ID_MENSAJE_NEW\"";
	$rs = $db->Execute($sql);
	while (!$rs->EOF){
		$cadena = ($cadena==""?$rs->fields['ID_MENSAJE_NEW']:$cadena.",".$rs->fields['ID_MENSAJE_NEW']);
		$message = ($message==""?sanitize2($rs->fields['MESSAGE']):$message."|".sanitize2($rs->fields['MESSAGE']));	
		$rs->MoveNext();
	}
	
	if($cadena!=""){			
		$sql = "UPDATE \"CHAT_MENSAJES_NEW\" SET \"RECD\"=1, \"RECEIVED\"=LOCALTIMESTAMP WHERE \"ID_MENSAJE_NEW\" in(".$cadena.")";
		$rs = $db->Execute($sql);		
	}
	
	if($query->Finalizar_Transaccion($db)==false){$message = "";}		
	$db->Close();
	$rs->Close();
		
	echo $message;
	exit();	
}else if ($_POST['action'] == "chatheartbeat_status") { //***********************Recibir Mensajes********************//
	$msg = $_POST['msg'];
	if($msg!=""){	
		$db = $query->Iniciar_Transaccion($query);
		$sql = "SELECT \"ID_MENSAJE_NEW\", \"RECD\" FROM \"CHAT_MENSAJES_NEW\" WHERE \"ID_MENSAJE_NEW\" IN(".$msg.")";
		$rs = $db->Execute($sql);
		while (!$rs->EOF){		
			$message = ($message==""?$rs->fields['ID_MENSAJE_NEW']."-".$rs->fields['RECD']:$message.",".$rs->fields['ID_MENSAJE_NEW']."-".$rs->fields['RECD']);	
			$rs->MoveNext();
		}
		echo ($query->Finalizar_Transaccion($db)?$message:"");		
		$db->Close();
		$rs->Close();
	}else echo "";
}else if ($_POST['action'] == "sendchat") { //***********************Enviar Mensajes********************//
	$from = $_POST['from_de'];
	$to = $_POST['to'];
	$message = $_POST['message'];
	$id_conversacion2 = $_POST['conversacion'];
	$id_conversacion_op = $_POST['conversacion_op'];
	$id_operador2 = $_POST['operador'];

	if($from=="" || $to=="")
	   exit();

	$messages = sanitize($message);

	if($id_conversacion2=="" && $id_conversacion_op==""){//este es el operador
		$rs = $query->Consultar($query,"max(\"ID_CONVERSACION\")","\"CHAT_CONVERSACIONES\"","\"ID_OPERADOR\"=".$id_operador2." AND \"FIN\" IS NULL","");
		$id_conversacion2 = $rs->fields[0];
		if($id_conversacion2==0){
			$rs = $query->Consultar($query,"max(\"ID_CONVERSACION\")","\"CHAT_CONVERSACIONES\"","\"ID_OPERADOR\"=".$id_operador2,"");
			$id_conversacion2 = $rs->fields[0];
		}
	        $rs->Close();
	}else
        $id_conversacion2 = ($id_conversacion_op!=""?$id_conversacion_op:$id_conversacion2);

	$db = $query->Iniciar_Transaccion($query);

	$sql = "insert into \"CHAT_MENSAJES_NEW\"(\"ID_CONVERSACION\",\"FROMM\",\"TOO\",\"MESSAGE\",\"SENT\",\"RECD\") ";
	$sql .=" values (".$id_conversacion2.",'".addslashes($from)."','".addslashes($to)."','".addslashes($message)."',LOCALTIMESTAMP,0)";
	$db->Execute($sql);
	$id_mensaje = $db->insert_Id();
	echo ($query->Finalizar_Transaccion($db)?$id_mensaje:0);
	$db->Close();
	exit();
}else if ($_POST['action'] == "closechat") { //***********************Cierre de Ventana********************//
	$from = $_POST['from_de'];
	$to = $_POST['chatbox'];
	$id_conversacion2 = $_POST['conversacion'];
	$id_conversacion_op = $_POST['conversacion_op'];
	$id_operador2 = $_POST['operador'];
	$id_institucion = $_POST['inst'];
	
	if($id_conversacion2=="" && $id_conversacion_op==""){//este es el operador
		$rs = $query->Consultar($query,"max(\"ID_CONVERSACION\")","\"CHAT_CONVERSACIONES\"","\"ID_OPERADOR\"=".$id_operador2." AND \"FIN\" IS NULL","");
		$id_conversacion2 = $rs->fields[0];
		if($id_conversacion2==0){
			$rs = $query->Consultar($query,"max(\"ID_CONVERSACION\")","\"CHAT_CONVERSACIONES\"","\"ID_OPERADOR\"=".$id_operador2,"");
			$id_conversacion2 = $rs->fields[0];
		}
	}else
        $id_conversacion2 = ($id_conversacion_op!=""?$id_conversacion_op:$id_conversacion2);

	$db = $query->Iniciar_Transaccion($query);

	if($_POST['conversacion']!=""){//Usuario Externo
		$sql = "insert into \"CHAT_MENSAJES_NEW\"(\"FROMM\",\"TOO\",\"MESSAGE\",\"SENT\",\"ID_CONVERSACION\",\"RECD\") values ('".$from."', '".$to."','Sesion terminada por el usuario',LOCALTIMESTAMP,".$id_conversacion2.",0)";
		$db->Execute($sql);
	        $id_mensaje = $db->insert_Id();
		$sql = "update \"CHAT_CONVERSACIONES\" set \"TRANSFER\"=3 where \"ID_CONVERSACION\"=".$id_conversacion2;
		$db->Execute($sql);
	}else{//Operador Locatel
		$sql = "insert into \"CHAT_MENSAJES_NEW\"(\"FROMM\",\"TOO\",\"MESSAGE\",\"SENT\",\"ID_CONVERSACION\",\"RECD\") values ('".$from."', '".$to."','Sesion terminada por el operador',LOCALTIMESTAMP,".$id_conversacion2.",1)";
		$db->Execute($sql);

		$sql = "update \"CHAT_CONVERSACIONES\" set \"FIN\"=LOCALTIMESTAMP, \"TRANSFER\"=3 where \"ID_CONVERSACION\"=".$id_conversacion2;
		$db->Execute($sql);

		$sql = "update \"CHAT_OPERADORES\" set \"STATUS\"=3 WHERE \"ID_OPERADOR\"=".$id_operador2." AND \"STATUS\"=2";
		$db->Execute($sql);
	}
	
		$sql = "UPDATE \"CHAT_AUTORIZACION\" SET \"STATUS\"=0 WHERE \"ID_CONVERSACION\"=".$id_conversacion2;
		$db->Execute($sql);
	
	$query->Finalizar_Transaccion($db);
	$db->Close();
	exit();	
}/*else if ($_POST['action'] == "openWindow") {
	$id_conversacion = $_POST['conversacion'];
	$db = $query->Iniciar_Transaccion($query);
	$sql = "UPDATE CHAT_CONVERSACIONES SET VENTANA=1 WHERE ID_CONVERSACION=".$id_conversacion;
	$rs = $db->Execute($sql);	
	$query->Finalizar_Transaccion($db);
	$db->Close();
	exit();	
}*/

function sanitize($text) {
	$text = htmlspecialchars($text, ENT_QUOTES);
	$text = str_replace("\n\r","\n",$text);
	$text = str_replace("\r\n","\n",$text);
	$text = str_replace("\n","<br>",$text);
	##$text = ereg_replace("[^A-Za-z0-9Ò—+.,@:°!;()_¡·…ÈÕÌ”Û⁄˙ø?<>]", "", $text);
	$text = preg_replace("[^A-Za-z0-9Ò—+.,@:°!;()_¡·…ÈÕÌ”Û⁄˙ø?<>]", "", $text);
	$text = InjectSQL($text,0);
	return $text;
}

function sanitize2($text) {
	$text = htmlspecialchars($text, ENT_QUOTES);
	$text = str_replace("\n\r","\n",$text);
	$text = str_replace("\r\n","\n",$text);
	$text = str_replace("\n","<br>",$text);
	$text = str_replace("/\"","'",$text);
	$text = str_replace("/\'","'",$text);
	return $text;
}

function InjectSQL($valor, $tipo){
	if($tipo==0){
		$palabras = array('"',"EXEC","LIKE","\x00","\n","\r","\í","\x1a","ì","ë","#","%","?","!",";","[","]","*",
		"UPDATE","SELECT","DELETE","INSERT","VALUES","inner","HTML","]","]","\x00","\x0a","\x0d","\x1a","\x09","xp_","--","<",">");
	}else{
		$palabras = array("EXEC","LIKE","\x00","\n","\r","\í","\x1a","ì","#","%","?","!",";","[","]","inner",
		"HTML","]","]","\x00","\x0a","\x0d","\x1a","\x09","xp_","--");//,"ë"
	}

	for ($i=0; $i<count($palabras);$i++){$valor = str_replace($palabras[$i],"",$valor);}
	return $valor;
}
