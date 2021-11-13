<?php date_default_timezone_set('America/Mexico_City');
header('Content-Type: text/html; charset=iso-8859-1');
	$op = $_GET['op'];
	$ins = $_GET['inst'];
	$pr = $_GET['perfil'];
	$value = ($ins==1?'Chat Informativos':'Chat Psicologia');
	echo "<div style='width:70%;height:18px; font-weight:bold; align:center;-moz-border-radius: 5px; -webkit-border-radius: 5px; border-radius: 5px;background-color:#B61B1C;background-image:-webkit-gradient(linear,50% 0,50% 100%,color-stop(20%,#B61B1C),color-stop(90%,#F83437));background-image:-webkit-linear-gradient(#B61B1C 20%,#F83437 90%);background-image:-moz-linear-gradient(#B61B1C 20%,#F83437 90%);background-image:-o-linear-gradient(#B61B1C 20%,#F83437 90%);background-image:linear-gradient(#B61B1C 20%,#F83437 90%);color:#fff; margin-top:20px'>Conversaciones y Abandonos ".($op=="Acumulado"?"Acumulado":"del D&iacute;a Por Hora")."</div>";
	

	include_once('../adodb/adodb.inc.php');
	include_once('Sentencias.php');
	$query = new Sentencias();
	$cadena = "[\"".($op=="Acumulado"?"Fecha":"Hora")."\",\"Conversaciones\",\"Abandonos\"],";

	if($op=="Acumulado"){
		if($pr >= 3){
	echo "<br/><table><tr><td colspan='2'><select id='typeChat' class='select' onchange='ChangeId();'><option value='0'>Selecciona el Chat</option><option value='1' ".($ins==1?"selected":"").">Informativos</option><option value='3' ".($ins==3?"selected":"").">Jur&iacute;dico</option><option value='5' ".($ins==5?"selected":"").">M&eacute;dico</option><option value='2' ".($ins==2?"selected":"").">Psicolog&iacute;a</option><option value='4' ".($ins==4?"selected":"").">911 CDMX</option><option value='6' ".($ins==6?"selected":"").">Redes Sociales</option></select></td></tr></table><br/>";}
		$campos = "\"FECHA\", SUM(\"CONVERSACION\"), SUM(\"RECHAZO\")";
		$tablas = "\"CHAT_TOTALES\"";
		$rs = $query->Consultar($query,$campos,$tablas,"\"FECHA\">='".date('Y-m-d', strtotime('-1 month'))."' AND \"ID_INSTITUCION\"=".$ins." GROUP BY \"FECHA\"","\"FECHA\" DESC");
		while(!$rs->EOF){
			$sub_conv = $rs->fields[1];
			$sub_rech = $rs->fields[2];
			if($rs->fields[0]==date('Y-m-d')){
				$rs_hora = $query->Consultar($query,"COUNT(*)","\"CHAT_TOTALES\"","\"FECHA\" = TO_CHAR(current_date,'YYYY-MM-DD') AND \"HORA\" = TO_CHAR(LOCALTIMESTAMP,'HH24') AND \"ID_INSTITUCION\"=".$ins,"");
				if($rs_hora->fields[0]==0){
					$rs_conv = $query->Consultar($query,"COUNT(*)","\"CHAT_CONVERSACIONES\"","TO_CHAR(\"INICIO\",'YYYY-MM-DD') = TO_CHAR(curren_date,'YYYY-MM-DD') AND TO_CHAR(\"INICIO\",'HH24') = TO_CHAR(LOCALTIMESTAMP,'HH24') AND \"ID_INSTITUCION\"=".$ins,"");
					$sub_conv += $rs_conv->fields[0];

					$rs_rech = $query->Consultar($query,"count(*)","\"CHAT_ESPERA\"","TO_CHAR(\"ATENCION\",'YYYY-MM-DD') = TO_CHAR(current_date,'YYYY-MM-DD') AND TO_CHAR(\"ATENCION\",'HH24') = TO_CHAR(LOCALTIMESTAMP,'HH24') AND \"STATUS\"=0 AND \"ID_INSTITUCION\"=".$ins,"");
					$sub_rech += $rs_rech->fields[0];
				}
			}

			$cadena .= "[\"".date('d-m-y',strtotime($rs->fields[0]))."\",     ".$sub_conv.",     ".$sub_rech."],";//."\",     ".$dato
			$rs->MoveNext();
		}
	}else{
		if($pr >= 3){
	echo "<br/><table><tr><td colspan='2'><select id='typeChat' class='select' onchange='ChangeId();'><option value='0'>Selecciona el Chat</option><option value='1' ".($ins==1?"selected":"").">Informativos</option><option value='3' ".($ins==3?"selected":"").">Jur&iacute;dico</option><option value='5' ".($ins==5?"selected":"").">M&eacute;dico</option><option value='2' ".($ins==2?"selected":"").">Psicolog&iacute;a</option><option value='4' ".($ins==4?"selected":"").">911 CDMX</option><option value='6' ".($ins==6?"selected":"").">Redes Sociales</option></select></td></tr></table><br/>";}
		$fini = $_GET['fini'];
		$ffin = $_GET['ffin'];

		if($fini=="" && $ffin==""){
			$fini = date('Y-m-d');
			$ffin = $fini;
		}

		$campos = "\"HORA\", SUM(\"CONVERSACION\"), SUM(\"RECHAZO\")";
		//$dc = "(SELECT HORA, SUM(CONVERSACION) AS CONVERSACION, SUM(RECHAZO) AS RECHAZO FROM CHAT_TOTALES WHERE FECHA >='".$fini."' and  FECHA<='".$ffin."' GROUP BY HORA UNION SELECT TO_CHAR(LOCALTIMESTAMP,'HH24') AS HORA, (SELECT COUNT(*) from CHAT_CONVERSACIONES where TO_CHAR(INICIO,'YYYY-MM-DD') = TO_CHAR(date,'YYYY-MM-DD') AND TO_CHAR(INICIO,'HH24') = TO_CHAR(LOCALTIMESTAMP,'HH24')) AS CONVERSACION, (SELECT COUNT(*) FROM (SELECT *FROM CHAT_ESPERA WHERE TO_CHAR(ATENCION,'YYYY-MM-DD') = TO_CHAR(sysdate,'YYYY-MM-DD') AND TO_CHAR(ATENCION,'HH24') = TO_CHAR(LOCALTIMESTAMP,'HH24') AND STATUS=0)) AS RECHAZO FROM DUAL)";
		$dc = "(SELECT \"HORA\", SUM(\"CONVERSACION\") AS \"CONVERSACION\", SUM(\"RECHAZO\") AS \"RECHAZO\"  FROM \"CHAT_TOTALES\"  WHERE \"FECHA\" >='".$fini."' and  \"FECHA\"<='".$ffin."' AND \"ID_INSTITUCION\"=".$ins."  GROUP BY \"HORA\"  UNION  SELECT TO_CHAR(LOCALTIMESTAMP,'HH24') AS HORA,  (SELECT COUNT(*) from \"CHAT_CONVERSACIONES\" where TO_CHAR(\"INICIO\",'YYYY-MM-DD') = TO_CHAR(current_date,'YYYY-MM-DD') AND TO_CHAR(\"INICIO\",'HH24') = TO_CHAR(LOCALTIMESTAMP,'HH24') AND \"ID_INSTITUCION\"=".$ins.") AS \"CONVERSACION\",  (SELECT COUNT(*) FROM (SELECT * FROM \"CHAT_ESPERA\" WHERE TO_CHAR(\"ATENCION\",'YYYY-MM-DD') = TO_CHAR(current_date,'YYYY-MM-DD') AND \"ID_INSTITUCION\"=".$ins." AND TO_CHAR(\"ATENCION\",'HH24') = TO_CHAR(LOCALTIMESTAMP,'HH24') AND \"STATUS\"=0) b) AS \"RECHAZO\" )";
		
		echo "<table><tr><td><b>Fecha Inicio:</b></td><td><input type='text' id='DTFecha2' class='edit' readonly='readonly' value='$fini' /></td></tr><tr><td><b>Fecha Fin:</b></td><td><input type='text' id='DTFecha3' class='edit' readonly='readonly' value='$ffin' /></td></tr>";
		echo "<tr><td colspan='2' align='center'><br /><input type='button' value='Consultar' onclick=\"Consultar_X_Hora();\" class='boton'/><br /></td></tr>";
		echo "</table>";

		$rs = $query->Consultar($query,$campos,$dc." horas GROUP BY \"HORA\"","","\"HORA\" desc");
		while(!$rs->EOF){
			$cadena .= "[\"".$rs->fields[0].":00"."\",     ".$rs->fields[1].",     ".$rs->fields[2]."],";
			$rs->MoveNext();
		}
	}
	$cadena = trim($cadena, ',');

	echo "<input type='hidden' id='ttitulo' value='Gral_".$op."' />";
	echo "<input type='hidden' id='tdatos' value='$cadena' />";
	echo "<div id='chart_div' style=' margin-left:-50px; width: 800px; height:580px; border:red solid 0px;'></div>";
?>
