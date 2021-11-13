<?php date_default_timezone_set('America/Mexico_City');
	$mes = $_GET['periodo'];
	$ins = $_GET['inst'];
	
	header('Content-Type: text/html; charset=iso-8859-1');
	include_once('../adodb/adodb.inc.php');
	include_once('Sentencias.php');
	$query = new Sentencias();
	
    $cabecera = "width:50px;font-weight:bold;-moz-border-radius:3px; -webkit-border-radius:3px; border-radius:3px; background-color:#B61B1C;background-image:-webkit-gradient(linear,50% 0,50% 100%,color-stop(20%,#B61B1C),color-stop(90%,#F83437));background-image:-webkit-linear-gradient(#B61B1C 20%,#F83437 90%);background-image:-moz-linear-gradient(#B61B1C 20%,#F83437 90%);background-image:-o-linear-gradient(#B61B1C 20%,#F83437 90%);background-image:linear-gradient(#B61B1C 20%,#F83437 90%);color:#fff;";
	echo "<table style='width:90%' style='padding:10px;'>";
	echo "<tr><td align='center' style='$cabecera'>Fecha</td><td align='center' style='$cabecera'>Conversaciones</td><td align='center' style='$cabecera'>Abandonos</td></tr>";
	$rs_total = $query->Consultar($query,"FECHA, SUM(CONVERSACION), SUM(RECHAZO)","CHAT_TOTALES","FECHA between '".$mes."-01' and '".$mes."-31' AND ID_INSTITUCION=".$ins." GROUP BY FECHA","FECHA");		
	while(!$rs_total->EOF){
		$periodo = $rs_total->fields[0];
		$sub_conv = $rs_total->fields[1];
		$sub_rech = $rs_total->fields[2];
		if($periodo==date('Y-m-d')){
			$rs_hora = $query->Consultar($query,"COUNT(*)","CHAT_TOTALES","FECHA = TO_CHAR(sysdate,'YYYY-MM-DD') AND HORA = TO_CHAR(LOCALTIMESTAMP,'HH24') AND ID_INSTITUCION=".$ins,"");
			if($rs_hora->fields[0]==0){
				$rs_conv = $query->Consultar($query,"COUNT(*)","CHAT_CONVERSACIONES","TO_CHAR(INICIO,'YYYY-MM-DD') = TO_CHAR(sysdate,'YYYY-MM-DD') AND TO_CHAR(INICIO,'HH24') = TO_CHAR(LOCALTIMESTAMP,'HH24') AND ID_INSTITUCION=".$ins,"");
				$sub_conv += $rs_conv->fields[0];
				
				$rs_rech = $query->Consultar($query,"count(*)","CHAT_ESPERA","TO_CHAR(ATENCION,'YYYY-MM-DD') = TO_CHAR(sysdate,'YYYY-MM-DD') AND TO_CHAR(ATENCION,'HH24') = TO_CHAR(LOCALTIMESTAMP,'HH24') AND STATUS=0 AND ID_INSTITUCION=".$ins,"");
				$sub_rech += $rs_rech->fields[0];
			}	
		}
		echo "<tr align='center' style='font-weight:bold;'><td style='width:30%'>$periodo</td><td align='center' style='width:30%'>$sub_conv</td><td align='center'  style='width:30%'>$sub_rech</td></tr>";
		$rs_total->MoveNext();
	}
	echo "</table>";
?>