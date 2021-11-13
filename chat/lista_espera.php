<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
	date_default_timezone_set('America/Mexico_City');
	$inst = $_POST['inst'];
	$id_esp = $_POST['id_espera'];

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

	include_once('../adodb/adodb.inc.php');
	include_once('Sentencias.php');
	include_once('constantes.php');
	$query = new Sentencias();
	$rs = $query->Consultar($query,"\"STATUS\"","\"CHAT_ESPERA\"","\"ID_ESPERA\"=".$id_esp,"");
	if($rs->fields[0]==1){
		$db = $query->Iniciar_Transaccion($query);
		$sql = "UPDATE \"CHAT_ESPERA\" SET \"ATENCION\"=LOCALTIMESTAMP WHERE \"ID_ESPERA\"=".$id_esp." AND \"STATUS\"=1";
		$db->Execute($sql);
		if($query->Finalizar_Transaccion($db)){
			//$rs = $query->Consultar($query,"MIN(CHAT_ESPERA.ID_ESPERA)","CHAT_ESPERA","STATUS=1 AND ID_INSTITUCION=".$inst,"");
			$rs = $query->Consultar($query,"MIN(\"ID_ESPERA\")","\"CHAT_ESPERA\"","\"STATUS\"=1 AND \"ID_INSTITUCION\"=".$inst." and datediff('SS',\"ATENCION\",current_timestamp::timestamp(0))<".INA_MAX,"");
			//var_dump($rs);
			//echo "ID:".$id_esp ;
			//echo "\n".$rs->fields[0] ;
			if($rs->fields[0]==$id_esp){
			   usleep(rand(350,600)*1000);
			   //echo "igualdad";
			   $rs_estatus = $query->Consultar($query,"*","(SELECT \"ID_OPERADOR\", \"PSEUDONIMO\" FROM \"CHAT_OPERADORES\" WHERE \"STATUS\"=1 and \"PERFIL\"=1 AND \"ID_INSTITUCION\"=".$inst." ORDER BY random()) a","",""," limit 1");
			   if($rs_estatus->RecordCount()>0){
				        //echo "encontrol algo=";
				        include_once('navegador.php');
					$ip = $_SERVER['REMOTE_ADDR'];
					$id_operador = $rs_estatus->fields['ID_OPERADOR'];

					$db = $query->Iniciar_Transaccion($query);
					$sql = "UPDATE \"CHAT_OPERADORES\" SET \"STATUS\"=2 WHERE \"ID_OPERADOR\"=".$id_operador;


					$db->Execute($sql);
					$query->Finalizar_Transaccion($db);
                                        //echo "actualizo operadores";
					$lg_operador = $rs_estatus->fields['PSEUDONIMO'];

                $sql = "insert into \"CHAT_USUARIOS\"( \"NOMBRE\", \"CORREO\") values('".trim($_POST['nombre'])."','".$_POST['correo']."')";
                $db->Execute($sql);
                $id_usuario = $db->insert_Id();

                $sql = "insert into \"CHAT_CONVERSACIONES\"(\"ID_USUARIO\", \"ID_OPERADOR\", \"INICIO\", \"IP\", \"NAVEGADOR\", \"VERSION\", \"SO\", \"DISPOSITIVO\", \"VENTANA\", \"ID_ESPERA\",\"ID_INSTITUCION\",\"TRANSFER\") values(".$id_usuario.",".$id_operador.",LOCALTIMESTAMP,'".$ip."','".$navegador_corto."','".substr($version,0,19)."','".$platforma."',".$id_dispositivo.",0,".$id_esp.",".$inst.",0)";
                $db->Execute($sql);
                $id_conversacion = $db->insert_Id();



                $sql = "insert into \"CHAT_MENSAJES_NEW\"(\"ID_CONVERSACION\",\"FROMM\",\"TOO\",\"MESSAGE\",\"SENT\",\"RECD\") ";
                $sql .=" values(".$id_conversacion.",'".$nombre2."','".$lg_operador."','Usuario Conectado',LOCALTIMESTAMP,0)";
                $db->Execute($sql);
                $id_mensaje = $db->insert_Id();

					$sql = "UPDATE \"CHAT_ESPERA\" SET \"STATUS\"=2 WHERE \"ID_ESPERA\"=".$id_esp;
					$db->Execute($sql);

					if($query->Finalizar_Transaccion($db)){
						echo "<input id='id_operador' type='hidden' value='".$id_operador."'/>";
						echo "<input id='login_operador' type='hidden' value='".$lg_operador."'/>";
						echo "<input id='id_conversacion' type='hidden' value='".$id_conversacion."'/>";
						echo "<input id='t_username2' name='t_username2' type='hidden' value='".$nombre2."'/>";

						$fp = fopen('logs/dispositivos'.date("mY").'.txt', 'a');
						fwrite($fp, $id_conversacion."|".date("Y-m-d")."|".date("H:i:s")."|".$ip."|".$navegador_corto."|".$version."|".$platforma."|".$dispositivo."|".$agente."\r\n");fclose($fp);
						//sleep(1);
						echo "<div style='color:#ffffff'>redirect.</div>";
					}/*else
						echo "<div style='color:black'>nodisponible.</div>";*/
			   }
			}
		}
		$rs->Close();
		$db->Close();
	}else if($rs->fields[0]==0){
		echo "User_Abandono_Lista";
	}
?>
