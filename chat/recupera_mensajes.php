<?php 	
	include_once('../adodb/adodb.inc.php');
	include_once('Sentencias.php');
	
	$id = $_POST['id_conversacion'];
	$inst = $_POST['id_institucion'];
	$tp = $_POST['tp'];
	
	$query = new Sentencias();
	$rs = $query->Consultar($query,"FROMM, MESSAGE, RECD","CHAT_MENSAJES_NEW","RECD=1 AND ID_CONVERSACION=".$id,"SENT");	
	if($rs->RecordCount()>0){
		$user_msg = $rs->fields['FROMM'];
		$color = "#ff0000";
		$rs->MoveNext();
		if($inst==4 && $tp==1){			
			$color = "#ff0000";
		}else if($inst==1 && $tp==1){
			$color = "#BA007C";
		}
		while(!$rs->EOF){
			$mensajes.="<div class='chatboxmessage'>";
			$mensajes.="<font color='".($user_msg==$rs->fields['FROMM']?$color:"")."'><span class='chatboxmessagefrom'>";
			$mensajes.="<img src='".(($inst==1 || $inst==4) && $tp==1?'chat/':'')."images/".($user_msg==$rs->fields['FROMM']?'usuario':'operador'.($inst==4?'4':'1')).".png' style='margin:-8px 4px -4px -8px;' />".$rs->fields['FROMM'];
			$mensajes.="<img src='".(($inst==1 || $inst==4) && $tp==1?'chat/':'')."images/recibido.png' alt='Mensaje Recibido' title='Mensaje Recibido' style='cursor:hand; cursor:pointer; margin:-8px 4px -4px 4px;'/>";
			$mensajes.="</span><span class='chatboxmessagecontent'><p style='margin: 4 auto;'>".$rs->fields['MESSAGE']."</p></span></font></div>";			
			$rs->MoveNext();
		}
		echo $mensajes;
	}
?>