<?php	
	$accion = $_POST['accion'];
	$cnv = $_POST['id'];
	$tm = $_POST['tema'];
	$sub = $_POST['subtema'];
	$asu = $_POST['asunto'];
	$res = $_POST['respuesta'];
	$com = $_POST['comentario'];
	$fch = $_POST['fecha'];
	$opr = $_POST['operador'];
	$ini = $_POST['inicio'];
	$fin = $_POST['fin'];
	$dur = $_POST['duracion'];
	
	if($accion=="Registrar"){
		$sql = "INSERT INTO CHAT_CALIDAD (ID_CONVERSACION,ID_TEMA,ID_SUBTEMA,ID_ASUNTO,RESPUESTA,COMENTARIO,FECHA,OPERADOR,INICIO,FIN,DURACION) VALUES(";
		$sql .= $cnv.",".$tm.",".$sub.",".$asu.",".$res.",".$com.",'".$fch."',".$opr.",'".$ini."','".$fin."','".$dur."')";
	}else
		$sql = "UPDATE CHAT_CALIDAD SET ID_TEMA=".$tm.",ID_SUBTEMA=".$sub.",ID_ASUNTO=".$asu.",RESPUESTA=".$res.",COMENTARIO=".$com.", FECHA=LOCALTIMESTAMP WHERE ID_CONVERSACION=".$cnv;
	
	include_once('../../adodb/adodb.inc.php');
	include_once('../Sentencias.php');
	$query = new Sentencias();
	$db = $query->Iniciar_Transaccion($query);	
	$db->Execute($sql);
	if($query->Finalizar_Transaccion($db)){echo 1;}else{echo 0;}
?>