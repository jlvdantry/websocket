<?php
include_once('../adodb/adodb.inc.php');
include_once('Sentencias.php');
$query = new Sentencias();

if($_POST['tp']==1){
	if($_POST['token']!=""){		
		$rs = $query->Consultar($query,"STATUS","CHAT_AUTORIZACION","TOKEN='".$_POST['token']."'","");
		if($rs->fields['STATUS']==1){
			$db = $query->Iniciar_Transaccion($query);		
			$sql = "UPDATE CHAT_AUTORIZACION SET STATUS=2 WHERE TOKEN='".$_POST['token']."'";
			$db->Execute($sql);
			echo ($query->Finalizar_Transaccion($db)?1:-1);
		}else if($rs->fields['STATUS']!=""){
			echo $rs->fields['STATUS'];
		}else{echo -1;}
	}else{echo -1;}
}else if($_POST['tp']==2){//recuperar datos de sesion
	$rs = $query->Consultar($query,"ID_CONVERSACION,ID_ESPERA","CHAT_AUTORIZACION","TOKEN='".$_POST['token']."'","");
	$id_conversacion = $rs->fields['ID_CONVERSACION'];
	$id_espera = $rs->fields['ID_ESPERA'];
	
	if($id_conversacion!=""){
		$rs_renueva = $query->Consultar($query,"cnv.ID_CONVERSACION, op.ID_OPERADOR, op.PSEUDONIMO, us.NOMBRE","CHAT_CONVERSACIONES cnv, CHAT_OPERADORES op, CHAT_USUARIOS us","cnv.ID_USUARIO = us.ID_USUARIO AND cnv.ID_OPERADOR = op.ID_OPERADOR AND cnv.ID_CONVERSACION=".$id_conversacion,"");
		if($rs_renueva->RecordCount()>0){
			$nombre2 = trim($rs_renueva->fields['NOMBRE']);
			$nombre2 = str_replace('@','_',$nombre2);
			$nombre2 = str_replace(' ','_',$nombre2);
			$nombre2 = str_replace('.','_',$nombre2);
			$nombre2 = str_replace(',','_',$nombre2);
			//$nombre2 = str_replace('-','_',$nombre2);
			$nombre2 = str_replace('á','a',$nombre2);
			$nombre2 = str_replace('é','e',$nombre2);
			$nombre2 = str_replace('í','i',$nombre2);
			$nombre2 = str_replace('ó','o',$nombre2);
			$nombre2 = str_replace('ú','u',$nombre2);
			$nombre2 = str_replace('Á','A',$nombre2);
			$nombre2 = str_replace('É','E',$nombre2);
			$nombre2 = str_replace('Í','I',$nombre2);
			$nombre2 = str_replace('Ó','O',$nombre2);
			$nombre2 = str_replace('Ú','U',$nombre2);
			$nombre2 = str_replace('ñ','n',$nombre2);
			$nombre2 = str_replace('Ñ','N',$nombre2);
			$nombre2 = preg_replace('/[^A-Za-z0-9\-_]/', '', $nombre2);
									
			echo "<input id='id_operador' type='hidden' value='".$rs_renueva->fields['ID_OPERADOR']."'/>";
			echo "<input id='login_operador' type='hidden' value='".$rs_renueva->fields['PSEUDONIMO']."'/>";
			echo "<input id='id_conversacion' type='hidden' value='".$rs_renueva->fields['ID_CONVERSACION']."'/>";
			echo "<input id='t_username2' name='t_username2' type='hidden' value='".$nombre2."'/>";
		}
	}else{
		$db = $query->Iniciar_Transaccion($query);		
		$sql = "UPDATE CHAT_AUTORIZACION SET ID_ESPERA='' WHERE TOKEN='".$_POST['token']."'";
		$db->Execute($sql);
		$query->Finalizar_Transaccion($db);
	}
}else if($_POST['tp']==3){//CHAT 9-1-1
	$rs = $query->Consultar($query,"STATUS, ID_CONVERSACION, ID_ESPERA","CHAT_AUTORIZACION","TOKEN='".$_POST['token']."'","");	
	if($rs->fields['STATUS']==2){
		$rs = $query->Consultar($query,"aut.STATUS, aut.ID_CONVERSACION, us.NOMBRE, us.CORREO, cnv.ID_INSTITUCION, aut.ID_ESPERA","CHAT_AUTORIZACION aut, CHAT_CONVERSACIONES cnv, CHAT_USUARIOS us","aut.ID_CONVERSACION = cnv.ID_CONVERSACION AND cnv.ID_USUARIO = us.ID_USUARIO AND aut.TOKEN='".$_POST['token']."'","");
		if($rs->RecordCount()>0){
			echo $rs->fields['STATUS']."|".$rs->fields['ID_CONVERSACION']."|".$rs->fields['ID_ESPERA']."|".$rs->fields['ID_INSTITUCION']."|".$rs->fields['NOMBRE']."|".$rs->fields['CORREO'];
		}else{
			$rs = $query->Consultar($query,"STATUS, ID_CONVERSACION, ID_ESPERA","CHAT_AUTORIZACION","TOKEN='".$_POST['token']."'","");
			echo $rs->fields['STATUS']."|".$rs->fields['ID_CONVERSACION']."|".$rs->fields['ID_ESPERA']."|-1||";	
		}	
	}else echo $rs->fields['STATUS']."|".$rs->fields['ID_CONVERSACION']."|".$rs->fields['ID_ESPERA']."|-1||";
}else if($_POST['tp']==4){//CHAT LOCATEL MIGRANTE
	$rs = $query->Consultar($query,"aut.STATUS, aut.ID_CONVERSACION, us.NOMBRE, us.CORREO, cnv.ID_INSTITUCION, aut.ID_ESPERA","CHAT_AUTORIZACION aut, CHAT_CONVERSACIONES cnv, CHAT_USUARIOS us","aut.ID_CONVERSACION = cnv.ID_CONVERSACION
AND cnv.ID_USUARIO = us.ID_USUARIO AND aut.TOKEN='".$_POST['token']."'","");
	if($rs->RecordCount()>0){
		echo $rs->fields['STATUS']."|".$rs->fields['ID_CONVERSACION']."|".$rs->fields['ID_ESPERA']."|".$rs->fields['ID_INSTITUCION']."|".$rs->fields['NOMBRE']."|".$rs->fields['CORREO'];
	}else{
		$rs = $query->Consultar($query,"STATUS, ID_CONVERSACION, ID_ESPERA","CHAT_AUTORIZACION","TOKEN='".$_POST['token']."'","");
		echo $rs->fields['STATUS']."|".$rs->fields['ID_CONVERSACION']."|".$rs->fields['ID_ESPERA']."|-1||";	
	}
}
?>