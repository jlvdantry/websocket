<?php
	$ip = $_SERVER['REMOTE_ADDR'];
	$us = $_GET['us'];
	$ps = $_GET['ps'];

	$regex = '#^[a-z0-9]*$#i';
	if(!(preg_match($regex, $us))){
		echo "Datos Incorrectos";
		exit();
	}
	/*if(!(preg_match($regex, $ps))){
		echo "Datos Incorrectos";
		exit();
	}*/
	include_once('../adodb/adodb.inc.php');
	//echo "paso adodb";
	include_once('Sentencias.php');
	//echo "paso sentencias\n";
	$query = new Sentencias();
	//echo "paso new sentencias\n";
	$db = $query->Iniciar_Transaccion($query);
	//echo "paso Iniciar_Transaccion\n";

	$sql = "SELECT * FROM \"CHAT_OPERADORES\" where \"LOGIN\" = '".trim($us)."' and \"PASS\" ='".md5(trim($ps))."'";
	$rs = $db->Execute($sql);
	//echo "paso ejecuto sql\n";
	$respuesta = $rs->RecordCount();
	//echo "paso recordcount=".$respuesta." estatus=".$rs->fields['STATUS']."\n";
	if($respuesta>0){
		if($rs->fields['STATUS']==-1){
			//echo "No es posible Iniciar Sesión<br />Usuario Deshabilitado.";
			$query->Finalizar_Transaccion($db);
			$db->Close();
			exit();
		}else if($rs->fields['PERFIL']==1 && $rs->fields['STATUS']==2 && $ip!=$rs->fields['IP']){
			//echo "No es posible Iniciar Sesión<br />hay una sesión activa.";
			$query->Finalizar_Transaccion($db);
			$db->Close();
			exit();
		}else if($rs->fields['PERFIL']==1 && ($rs->fields['STATUS']==1 || $rs->fields['STATUS']==3)){
			//echo "No es posible Iniciar Sesión<br />hay una sesión activa.";
			$query->Finalizar_Transaccion($db);
			$db->Close();
			exit();
		}

		$host = str_replace('$','',getenv("username"));
		//echo "/valida_sesion_chat antes de navegador";
		//include_once('navegador.php');
		//echo "/valida_sesion_chat paso navegadores";

                //* se comentariza para que sea controlado por el socket 
		$sql = "update \"CHAT_OPERADORES\" set \"STATUS\"=".($rs->fields['PERFIL']==1?($rs->fields['STATUS']!=2?3:2):1).", \"INICIO\"=current_timestamp, \"IP\"='$ip', \"SALIDA\"=null, \"HOST\"='".$host."', \"NAVEGADOR\"='".$navegador_corto." ".$version."' where \"ID_OPERADOR\"=".$rs->fields['ID_OPERADOR'];
		$db->Execute($sql);

		/*ini_set("session.cookie_lifetime", 28800);
		ini_set("session.gc_maxlifetime", 28800);*/
		session_start();
		$_SESSION['username'] = $rs->fields['PSEUDONIMO'];//trim($us);
		$_SESSION['nombre'] = $rs->fields['NOMBRE'];
		$_SESSION['login'] = $rs->fields['LOGIN'];
		$_SESSION['inicio'] = date("Y-m-d H:i");
		$_SESSION['id_operador'] = $rs->fields['ID_OPERADOR'];
		echo "<div style='color:white;display:none'>redirect.</div><input type='hidden' id='tid' name='tid' value='".$rs->fields['ID_OPERADOR']."' /><input type='hidden' id='tperfil' name='tperfil' value='".$rs->fields['PERFIL']."' /><input id='t_username2' name='t_username2' type='hidden' value='".$rs->fields['PSEUDONIMO']."' /><input id='id_institucion2' name='id_institucion2' type='hidden' value='".$rs->fields['ID_INSTITUCION']."' />";
	}else
		echo "Datos Incorrectos";

	$query->Finalizar_Transaccion($db);
	$db->Close();
?>
