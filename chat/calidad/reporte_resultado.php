<?php 
header("Content-type: application/vnd.ms-excel;");
header("Content-type:   application/x-msexcel;");
header("Content-Disposition: attachment; filename=CHAT_CALIDAD_".date("Y-m-d_His").".xls");;
header("Pragma: no-cache");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: private",false);

set_time_limit(0);
ini_set("memory_limit", "200M");
ini_set("max_execution_time", "999");
$fi = $_GET['fi'];
$ff = $_GET['ff'];

$meses = array("","Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
$respuestas = array("N/A","Satisfactoria","No Satisfactoria");
$comentarios = array("","Operador no recibió respuesta por parte del usuario","Operador solicitó al usuario que se comunique con área correspondiente","Usuario no recibió respuesta por parte del operador","Usuario terminó sesión");

include_once('../../adodb/adodb.inc.php');
include_once('../Sentencias.php');
$query = new Sentencias();
$campos = "cl.\"ID_CONVERSACION\" as FOLIO, TO_CHAR(cnv.\"INICIO\",'DD-MM-YYYY') AS FECHA, TO_CHAR(cnv.\"INICIO\",'MM') AS MES, op.\"NOMBRE\" as OPERADOR, TO_CHAR(cnv.\"INICIO\",'HH24:MI:SS') AS INICIO, TO_CHAR(cnv.\"FIN\",'HH24:MI:SS') AS FIN, TO_CHAR((cnv.\"FIN\"-cnv.\"INICIO\"),'HH24:MI:SS') AS DURACION, tm.\"DESCRIPCION\" as TEMA, sub.\"DESCRIPCION\" as SUBTEMA, asn.\"DESCRIPCION\" as ASUNTO, cl.\"RESPUESTA\", cl.\"COMENTARIO\"";
$tablas = "\"CHAT_OPERADORES\" op, \"CHAT_CONVERSACIONES\" cnv, \"CHAT_CALIDAD\" cl LEFT JOIN \"CHAT_TEMA\" tm ON cl.\"ID_TEMA\" = tm.\"ID_TEMA\" LEFT JOIN \"CHAT_SUBTEMA\" sub ON cl.\"ID_SUBTEMA\" = sub.\"ID_SUBTEMA\" LEFT JOIN \"CHAT_ASUNTO\" asn ON cl.\"ID_ASUNTO\" = asn.\"ID_ASUNTO\"";
$criterio = "cl.\"ID_CONVERSACION\" = cnv.\"ID_CONVERSACION\" and cnv.\"ID_OPERADOR\" = op.\"ID_OPERADOR\" and TO_CHAR(cnv.\"INICIO\",'YYYY-MM-DD')>='".$fi."' and TO_CHAR(cnv.\"INICIO\",'YYYY-MM-DD')<='".$ff."'";
$rs = $query->Consultar($query,$campos,$tablas,$criterio,"op.\"NOMBRE\", cl.\"ID_CONVERSACION\"");
echo "<table style='font-size:14px'>";
echo "<tr style='background:#000; color:white; text-align:center; font-weight:bold;'><td>FOLIO</td><td>FECHA</td><td>MES</td><td>OPERADOR</td><td>INICIO</td><td>FIN</td><td>DURACION</td><td>TEMA</td><td>SUBTEMA</td><td>ASUNTO</td><td>RESPUESTA</td><td>COMENTARIO</td></tr>";
while(!$rs->EOF){
	$datos = explode(" ",$rs->fields['DURACION']);
	$duracion = $datos[1];
	$mes = (int)$rs->fields['MES'];
	echo "<tr>";
	echo "<td>".$rs->fields['FOLIO']."</td>";
	echo "<td>".$rs->fields['FECHA']."</td>";
	echo "<td>".$meses[$mes]."</td>";
	echo "<td>".utf8_decode($rs->fields['OPERADOR'])."</td>";
	echo "<td>".$rs->fields['INICIO']."</td>";
	echo "<td>".$rs->fields['FIN']."</td>";
	echo "<td>".$duracion."</td>";
	echo "<td>".utf8_decode($rs->fields['TEMA'])."</td>";
	echo "<td>".utf8_decode($rs->fields['SUBTEMA'])."</td>";
	echo "<td>".utf8_decode($rs->fields['ASUNTO'])."</td>";
	echo "<td>".utf8_decode($respuestas[$rs->fields['RESPUESTA']])."</td>";
	echo "<td>".utf8_decode($comentarios[$rs->fields['COMENTARIO']])."</td>";
	echo "</tr>";
	$rs->MoveNext();
}
echo "</table>";
?>
