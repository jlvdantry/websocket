<?php //session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

	date_default_timezone_set('America/Mexico_City');

	if(trim($_POST['nombre'])==""){
		echo "FaltaNombre.";
		exit();
	}

	if(trim($_POST['correo'])==""){
		echo "FaltaCorreo.";
		exit();
	}

	$id_ins = $_POST['inst'];
	//sleep(1);
	include_once('../adodb/adodb.inc.php');
	include_once('Sentencias.php');
	include_once('constantes.php');
	$query = new Sentencias();

	$ip = $_SERVER['REMOTE_ADDR'];
	$fechaini = date('Y-m-d H:i:s',strtotime('-5 minute',strtotime(date('Y-m-d H:i:s'))));
	$fechafin = date('Y-m-d H:i:s');
    include_once('navegador.php');

	$nombre2 = trim($_POST['nombre2']);
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

	$rs = $query->Consultar($query,"count(*)","\"CHAT_ESPERA\"","\"STATUS\"=1 AND \"ID_INSTITUCION\"=".$id_ins." and DateDiff('SS',\"ATENCION\",current_timestamp::timestamp(0))<".INA_MAX,"");
	if($rs->fields[0]>0){
		$personas_espera = "<img src='chat/images/load_chat.gif' border='0' /><br>Gracias por usar el servicio<br>de Chat de ".($id_ins==4?"9-1-1 Emergencias":"Locatel").",<br>por favor permanezca en l&iacute;nea,<br>en un momento le atenderemos.";
		$db = $query->Iniciar_Transaccion($query);


		$sql = "insert into \"CHAT_ESPERA\"(\"NOMBRE\",\"CORREO\",\"IP\",\"ENTRADA\",\"ATENCION\",\"STATUS\",\"ID_INSTITUCION\") values('".$_POST['nombre']."','".$_POST['correo']."','".$ip."',LOCALTIMESTAMP,LOCALTIMESTAMP,1,".$id_ins.")";
		$db->Execute($sql);
                $id_espera=$db->insert_Id();

		$query->Finalizar_Transaccion($db);
		echo "<div style='color:#ffffff'>coladeespera.</div><input type='hidden' id='id_espera' value='".$id_espera."' />".$personas_espera;
		$rs->Close();
		exit();
	}else{	//cuando no hay cola y los operadores estan disponibles pasa directo, sino se le manda como primera opcion a la lista de espera
		//sleep(1);
		$rs_estatus = $query->Consultar($query,"*","(SELECT * FROM \"CHAT_OPERADORES\" WHERE \"STATUS\"=1 and \"PERFIL\"=1 AND \"ID_INSTITUCION\"=".$id_ins." ORDER BY random()) a","",""," limit 1");
		if($rs_estatus->RecordCount()<=0){
			$personas_espera = "<img src='chat/images/load_chat.gif' border='0' /><br>Gracias por usar el servicio<br>de Chat de ".($id_ins==4?"9-1-1 Emergencias":"Locatel").",<br>por favor permanezca en l&iacute;nea,<br>en un momento le atenderemos.";
			$db = $query->Iniciar_Transaccion($query);


			$sql = "insert into \"CHAT_ESPERA\"(\"NOMBRE\",\"CORREO\",\"IP\",\"ENTRADA\",\"ATENCION\",\"STATUS\",\"ID_INSTITUCION\") values('".$_POST['nombre']."','".$_POST['correo']."','".$ip."',LOCALTIMESTAMP,LOCALTIMESTAMP,1,".$id_ins.")";
			$db->Execute($sql);
                        $id_espera=$db->insert_Id();


			$query->Finalizar_Transaccion($db);
			echo "<div style='color:#ffffff'>coladeespera.</div><input type='hidden' id='id_espera' value='".$id_espera."' />".$personas_espera;
			$rs->Close();
			$rs_estatus->Close();
			$db->Close();
			exit();
		}
		$id_operador = $rs_estatus->fields['ID_OPERADOR'];

		$db = $query->Iniciar_Transaccion($query);
		$sql = "UPDATE \"CHAT_OPERADORES\" SET \"STATUS\"=2 WHERE \"ID_OPERADOR\"=".$id_operador." AND \"ID_INSTITUCION\"=".$id_ins;
		$db->Execute($sql);
		//jlv $query->Finalizar_Transaccion($db);

		$lg_operador = $rs_estatus->fields['PSEUDONIMO'];

		//jlv $db = $query->Iniciar_Transaccion($query);


		$sql = "insert into \"CHAT_USUARIOS\"( \"NOMBRE\", \"CORREO\") values('".trim($_POST['nombre'])."','".$_POST['correo']."')";
		$db->Execute($sql);
                $id_usuario = $db->insert_Id();

		$sql = "insert into \"CHAT_CONVERSACIONES\"(\"ID_USUARIO\", \"ID_OPERADOR\", \"INICIO\", \"IP\", \"NAVEGADOR\", \"VERSION\", \"SO\", \"DISPOSITIVO\", \"VENTANA\", \"ID_ESPERA\",\"ID_INSTITUCION\",\"TRANSFER\") values(".$id_usuario.",".$id_operador.",LOCALTIMESTAMP,'".$ip."','".$navegador_corto."','".substr($version,0,19)."','".$platforma."',".$id_dispositivo.",0,null,".$id_ins.",0)";
		$db->Execute($sql);
                $id_conversacion = $db->insert_Id();

		$sql = "insert into \"CHAT_MENSAJES_NEW\"(\"ID_CONVERSACION\",\"FROMM\",\"TOO\",\"MESSAGE\",\"SENT\",\"RECD\") ";
		$sql .=" values(".$id_conversacion.",'".$nombre2."','".$lg_operador."','Usuario Conectado',LOCALTIMESTAMP,0)";
		$db->Execute($sql);
		$id_mensaje = $db->insert_Id();


		if($query->Finalizar_Transaccion($db)){
			$rs->Close();
			$db->Close();

			echo "<input id='id_operador' type='hidden' value='".$id_operador."'/>";
			echo "<input id='login_operador' type='hidden' value='".$lg_operador."'/>";
			echo "<input id='id_conversacion' type='hidden' value='".$id_conversacion."'/>";
			echo "<input id='t_username2' name='t_username2' type='hidden' value='".$nombre2."'/>";

			date_default_timezone_set('America/Mexico_City');
			$fp = fopen('logs/dispositivos'.date("mY").'.txt', 'a');
			fwrite($fp, $id_conversacion."|".date("Y-m-d")."|".date("H:i:s")."|".$ip."|".$navegador_corto."|".$version."|".$platforma."|".$dispositivo."|".$agente."\r\n");fclose($fp);

			//sleep(2);
			echo "<div style='color:#ffffff'>redirect.</div>";
		}else
			echo "<div style='color:#ffffff'>nodisponible.</div>";
	}
?>
