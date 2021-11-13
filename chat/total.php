<?php 
	header('Content-Type: text/html; charset=iso-8859-1');
	$ins = $_GET['inst'];
	$pr = $_GET['perfil'];
	include_once('../adodb/adodb.inc.php');
	include_once('Sentencias.php');
	$query = new Sentencias();
		
	$meses = array("","ENE","FEB","MAR","ABR","MAY","JUN","JUL","AGO","SEP","OCT","NOV","DIC");
	$rs_periodos = $query->Consultar($query,"substr(\"FECHA\",0,7), SUM(\"CONVERSACION\"), SUM(\"RECHAZO\")","\"CHAT_TOTALES\"","\"ID_INSTITUCION\"=".$ins." GROUP BY substr(\"FECHA\",0,7)","substr(\"FECHA\",0,7)");
	
	$cabecera = "width:50px;font-weight:bold; -moz-border-radius:3px; -webkit-border-radius:3px; border-radius:3px;background-color:#B61B1C;background-image:-webkit-gradient(linear,50% 0,50% 100%,color-stop(20%,#B61B1C),color-stop(90%,#F83437));background-image:-webkit-linear-gradient(#B61B1C 20%,#F83437 90%);background-image:-moz-linear-gradient(#B61B1C 20%,#F83437 90%);background-image:-o-linear-gradient(#B61B1C 20%,#F83437 90%);background-image:linear-gradient(#B61B1C 20%,#F83437 90%);color:#fff;";
	echo "<br /><br /><div style='width:70%;height:18px; font-weight:bold; align:center;-moz-border-radius: 5px; -webkit-border-radius: 5px; border-radius: 5px;background-color:#B61B1C;background-image:-webkit-gradient(linear,50% 0,50% 100%,color-stop(20%,#B61B1C),color-stop(90%,#F83437));background-image:-webkit-linear-gradient(#B61B1C 20%,#F83437 90%);background-image:-moz-linear-gradient(#B61B1C 20%,#F83437 90%);background-image:-o-linear-gradient(#B61B1C 20%,#F83437 90%);background-image:linear-gradient(#B61B1C 20%,#F83437 90%);color:#fff;'>Reporte Diario y Acumulado</div><br />";
	if($pr >= 3){
	echo "<table>";
	echo "<tr><td colspan='2'><select id='typeChat' class='select' onchange='ChangeId();'><option value='0'>Selecciona el Chat</option><option value='1' ".($ins==1?"selected":"").">Informativos</option><option value='3' ".($ins==3?"selected":"").">Jur&iacute;dico</option><option value='5' ".($ins==5?"selected":"").">M&eacute;dico</option><option value='2' ".($ins==2?"selected":"").">Psicolog&iacute;a</option><option value='4' ".($ins==4?"selected":"").">911 CDMX</option></select></td></tr>";
	echo "</table><br />";}

	echo "<table style='width:70%'>";
	echo "<tr><td align='center' style='$cabecera'>Periodo</td><td align='center' style='$cabecera'>Conversaciones</td><td align='center' style='$cabecera'>Abandonos</td></tr>";	
	while(!$rs_periodos->EOF){		
		$mes = $rs_periodos->fields[0];
		$periodo = $meses[intval(substr($mes,5,2))]."/".substr($mes,0,4);
		$sub_conv = $rs_periodos->fields[1];
		$sub_rech = $rs_periodos->fields[2];
		
		if($mes==date('Y-m')){
			$rs_hora = $query->Consultar($query,"COUNT(*)","\"CHAT_TOTALES\"","\"FECHA\" = TO_CHAR(sysdate,'YYYY-MM-DD') AND \"HORA\" = TO_CHAR(LOCALTIMESTAMP,'HH24') AND \"ID_INSTITUCION\"=".$ins,"");
			if($rs_hora->fields[0]==0){
				$rs_conv = $query->Consultar($query,"COUNT(*)","\"CHAT_CONVERSACIONES\"","TO_CHAR(\"INICIO\",'YYYY-MM-DD') = TO_CHAR(curren_date,'YYYY-MM-DD') AND TO_CHAR(\"INICIO\",'HH24') = TO_CHAR(LOCALTIMESTAMP,'HH24') AND \"ID_INSTITUCION\"=".$ins,"");
				$sub_conv += $rs_conv->fields[0];
				
				$rs_rech = $query->Consultar($query,"count(*)","\"CHAT_ESPERA\"","TO_CHAR(\"ATENCION\",'YYYY-MM-DD') = TO_CHAR(current_date,'YYYY-MM-DD') AND TO_CHAR(\"ATENCION\",'HH24') = TO_CHAR(LOCALTIMESTAMP,'HH24') AND \"STATUS\"=0  AND \"ID_INSTITUCION\"=".$ins,"");
				$sub_rech += $rs_rech->fields[0];
			}
		}
		
		$tconv += $sub_conv;
		$trech += $sub_rech;
		
		echo "<tr align='center' style='font-weight:bold;'><td><a href='#' onclick=\"Total_Diario('".$mes."')\">$periodo</a></td><td align='center'>".number_format($sub_conv)."</td><td align='center'>".number_format($sub_rech)."</td></tr>";
		echo "<tr><td colspan='3' align='center'><div id='".str_replace("-","",$mes)."' style='display:none;'></div></td></tr>";
		
		$rs_periodos->MoveNext();
	}
	echo "<tr align='center'><td style='$cabecera'>Acumulado</td><td align='center' style='$cabecera'>".number_format($tconv)."</td><td align='center' style='$cabecera'>".number_format($trech)."</td></tr>";
	echo "</table><br /><br /><br />";
?>
