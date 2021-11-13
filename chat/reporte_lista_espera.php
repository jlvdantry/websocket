<?php date_default_timezone_set('America/Mexico_City');
$id_ins = $_GET['inst'];
echo "<div style='width:70%;height:18px; margin-top:18px; font-weight:bold; align:center;-moz-border-radius: 5px;-webkit-border-radius:5px;border-radius:5px;background-color:#B61B1C;background-image:-webkit-gradient(linear,50% 0,50% 100%,color-stop(20%,#B61B1C),color-stop(90%,#F83437));background-image:-webkit-linear-gradient(#B61B1C 20%,#F83437 90%);background-image:-moz-linear-gradient(#B61B1C 20%,#F83437 90%);background-image:-o-linear-gradient(#B61B1C 20%,#F83437 90%);background-image:linear-gradient(#B61B1C 20%,#F83437 90%);color:#fff;'>N&uacute;meros del d&iacute;a</div><br /><br />";
	include_once('../adodb/adodb.inc.php');
	include_once('Sentencias.php');
	include_once('constantes.php');
	$query = new Sentencias();

	//$rs_dia_atendidos = $query->Consultar($query,"COUNT(*)",""CHAT_CONVERSACIONES"","TO_CHAR(INICIO,'YYYY-MM-DD')=TO_CHAR(sysdate,'YYYY-MM-DD') AND FIN IS NOT NULL","");
	//$rs_dia_atendidos = $query->Consultar($query,"COUNT(*)",""CHAT_CONVERSACIONES"","INICIO >='".date('m-d-Y')." 00:00:00.000' AND FIN IS NOT NULL","");
	//$rs_hora_atendidos = $query->Consultar($query,"COUNT(*)",""CHAT_CONVERSACIONES"","round((cast(localtimestamp as date)-cast(INICIO as date))*24*60)<=60 AND FIN IS NOT NULL","");
	//$rs_media_atendidos = $query->Consultar($query,"COUNT(*)",""CHAT_CONVERSACIONES"","round((cast(localtimestamp as date)-cast(INICIO as date))*24*60)<=30 AND FIN IS NOT NULL","");


	//$rs_dia_atendidos = $query->Consultar($query,"COUNT(*)",""CHAT_CONVERSACIONES"","INICIO>='".date('d/m/y')."' AND FIN IS NOT NULL AND ID_INSTITUCION=".$id_ins,"");
	$rs_dia_atendidos = $query->Consultar($query,"COUNT(*)","\"CHAT_CONVERSACIONES\"","TO_CHAR(\"INICIO\",'YYYY-MM-DD')=TO_CHAR(current_date,'YYYY-MM-DD') AND \"FIN\" IS NOT NULL AND \"ID_INSTITUCION\"=".$id_ins,"");
	$rs_hora_atendidos = $query->Consultar($query,"COUNT(*)","\"CHAT_CONVERSACIONES\"","\"FIN\" IS NOT NULL AND \"INICIO\" >= current_date - interval '60' minute AND \"ID_INSTITUCION\"=".$id_ins,"");
	$rs_media_atendidos = $query->Consultar($query,"COUNT(*)","\"CHAT_CONVERSACIONES\"","\"FIN\" IS NOT NULL AND \"INICIO\" >= current_date - interval '30' minute AND \"ID_INSTITUCION\"=".$id_ins,"");


	//$rs_ahora_atendidos = $query->Consultar($query,"COUNT(*)",""CHAT_CONVERSACIONES"","TO_CHAR(INICIO,'YYYY-MM-DD')=TO_CHAR(sysdate,'YYYY-MM-DD') AND FIN IS NULL","");
	$rs_ahora_atendidos = $query->Consultar($query,"COUNT(*)","\"CHAT_CONVERSACIONES\"","TO_CHAR(\"INICIO\",'YYYY-MM-DD')=TO_CHAR(current_date,'YYYY-MM-DD') AND \"FIN\" IS NULL AND \"ID_INSTITUCION\"=".$id_ins,"");

	echo "<table class='tabla' style='-moz-border-radius: 5px; -webkit-border-radius: 5px; border-radius: 5px; width:40%; float:left; margin-left:40px; border:2px solid gray;' cellspacing='0'>";
	echo "<tr><td colspan='4' class='tabla_cabecera' style='background: #b5bdc8; /* Old browsers */
background: -moz-linear-gradient(top, #b5bdc8 0%, #828c95 36%, #28343b 100%); /* FF3.6-15 */
background: -webkit-linear-gradient(top, #b5bdc8 0%,#828c95 36%,#28343b 100%); /* Chrome10-25,Safari5.1-6 */
background: linear-gradient(to bottom, #b5bdc8 0%,#828c95 36%,#28343b 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#b5bdc8', endColorstr='#28343b',GradientType=0 );'>TOTAL DE ATENDIDOS</td></tr>";
	echo "<tr class='tabla_cabecera'><td>".date('d-m-Y')."</td><td>60 mins.</td><td>30 mins.</td><td>Ahora</td></tr>";
	echo "<tr align='center' style='height:25px; font-size:18px; font-weight:bold'><td>".($rs_dia_atendidos->fields[0]>0?"<a href='#' style='font-weight:bold;' onclick=\"Reporte_del_Dia(1)\">".$rs_dia_atendidos->fields[0]."</a>":$rs_dia_atendidos->fields[0])."</td><td>".$rs_hora_atendidos->fields[0]."</td><td>".$rs_media_atendidos->fields[0]."</td><td>".$rs_ahora_atendidos->fields[0]."</td></tr>";
	echo "</table>";

	//$rs_dia = $query->Consultar($query,"COUNT(*)",""CHAT_ESPERA"",""STATUS"=0 AND TO_CHAR(ATENCION,'YYYY-MM-DD')=TO_CHAR(sysdate,'YYYY-MM-DD')","");

	//$rs_dia = $query->Consultar($query,"COUNT(*)",""CHAT_ESPERA"",""STATUS"=0 AND ATENCION>='".date('d/m/Y')."' AND ID_INSTITUCION=".$id_ins,"");
	$rs_dia = $query->Consultar($query,"COUNT(*)","\"CHAT_ESPERA\"","\"STATUS\"=1 AND TO_CHAR(\"ATENCION\",'YYYY-MM-DD')=TO_CHAR(current_date,'YYYY-MM-DD') AND \"ID_INSTITUCION\"=".$id_ins." and datediff('SS',\"ATENCION\",current_timestamp::timestamp(0))>".INA_MAX,"");
	$rs_hora = $query->Consultar($query,"COUNT(*)","\"CHAT_ESPERA\"","\"STATUS\"=1 AND \"ATENCION\" >= current_date - interval '60' minute AND \"ID_INSTITUCION\"=".$id_ins,"");
	$rs_media = $query->Consultar($query,"COUNT(*)","\"CHAT_ESPERA\"","\"STATUS\"=1  AND \"ATENCION\" >= current_date - interval '30' minute AND \"ID_INSTITUCION\"=".$id_ins,"");

	//$rs_hora = $query->Consultar($query,"COUNT(*)",""CHAT_ESPERA"",""STATUS"=0 AND round((cast(localtimestamp as date)-cast(atencion as date))*24*60)<=60","");
	//$rs_media = $query->Consultar($query,"COUNT(*)",""CHAT_ESPERA"",""STATUS"=0 AND round((cast(localtimestamp as date)-cast(atencion as date))*24*60)<=30","");

	echo "<table class='tabla' style='-moz-border-radius: 5px; -webkit-border-radius: 5px; border-radius: 5px; width:40%; border:2px solid gray;' cellspacing='0'>";
	echo "<tr><td colspan='3' class='tabla_cabecera' style='background: #b5bdc8; /* Old browsers */
background: -moz-linear-gradient(top, #b5bdc8 0%, #828c95 36%, #28343b 100%); /* FF3.6-15 */
background: -webkit-linear-gradient(top, #b5bdc8 0%,#828c95 36%,#28343b 100%); /* Chrome10-25,Safari5.1-6 */
background: linear-gradient(to bottom, #b5bdc8 0%,#828c95 36%,#28343b 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#b5bdc8', endColorstr='#28343b',GradientType=0 );'>TOTAL DE ABANDONOS</td></tr>";
	echo "<tr class='tabla_cabecera'><td>".date('d-m-Y')."</td><td>60 mins.</td><td>30 mins.</td></tr>";
	echo "<tr align='center' style='height:25px; font-size:18px; font-weight:bold'><td>".($rs_dia->fields[0]>0?"<a href='#' style='font-weight:bold;' onclick=\"Reporte_del_Dia(2)\">".$rs_dia->fields[0]."</a>":$rs_dia->fields[0])."</td><td>".$rs_hora->fields[0]."</td><td>".$rs_media->fields[0]."</td></tr>";
	echo "</table><br /><br />";

	$campos = "\"NOMBRE\", \"CORREO\", \"IP\", TO_CHAR((LOCALTIMESTAMP - \"ENTRADA\"),'HH24:MI') AS \"TIEMPO\",trunc(datediff('SS',\"ATENCION\",current_timestamp::timestamp(0))) \"SS\"";
	$tablas = "\"CHAT_ESPERA\"";
	$criterio = "\"STATUS\"=1 AND \"ID_INSTITUCION\"=".$id_ins." and datediff('SS',\"ATENCION\",current_timestamp::timestamp(0))<".INA_MAX;
	$orden = "\"ID_ESPERA\"";
	$rs = $query->Consultar($query,$campos,$tablas,$criterio,$orden);
	if($rs->RecordCount()>0){
		echo "<table class='tabla' style='width:95%;-moz-border-radius: 5px; -webkit-border-radius: 5px; border-radius: 5px; border:2px solid gray;' cellspacing='0'>";
		echo "<tr class='tabla_cabecera' style='background: #b5bdc8; /* Old browsers */
background: -moz-linear-gradient(top, #b5bdc8 0%, #828c95 36%, #28343b 100%); /* FF3.6-15 */
background: -webkit-linear-gradient(top, #b5bdc8 0%,#828c95 36%,#28343b 100%); /* Chrome10-25,Safari5.1-6 */
background: linear-gradient(to bottom, #b5bdc8 0%,#828c95 36%,#28343b 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#b5bdc8', endColorstr='#28343b',GradientType=0 );'><td colspan='6'>LISTA DE ESPERA (".number_format($rs->RecordCount(),0).")</td></tr>";
		echo "<tr class='tabla_cabecera'><td>##</td>";
		echo "<td>IP</td>";
		echo "<td>Nombre</td>";
		echo "<td>Correo</td>";
		echo "<td>Espera</td>";
		echo "<td>Inactiva SS</td></tr>";
		$contador = 1;
		while(!$rs->EOF){
			$tp = ($rs->fields['TIEMPO']==""?0:2);
			$time = $rs->fields['TIEMPO'];
			if($rs->fields['TIEMPO']!=""){
				$time = str_replace('+000000000 ','',$time);
				$time_split = explode('.',$time);
				$time = $time_split[0];
			}
			$time = ($time!=""?$time:"");
			echo "<tr align='center' ".($contador%2==0?"style='font-weight:bold; height:25px; font-size:13px;background: #ECEABD;'":"style='height:25px; font-size:13px; font-weight:bold'").">";
			echo "<td>".$contador."</td>";
			echo "<td>".$rs->fields['IP']."</td>";
			echo "<td>".$rs->fields['NOMBRE']."</td>";
			echo "<td>".$rs->fields['CORREO']."</td>";
			//echo "<td>".$time."</td>";
			echo "<td>".$rs->fields['TIEMPO']."</td>";
			echo "<td>".$rs->fields['SS']."</td></tr>";
			$rs->MoveNext();
			$contador++;
		}
		echo "</table>";
	}else
		echo "<h2>No hay usuarios en la lista de espera.</h2>";
?>
