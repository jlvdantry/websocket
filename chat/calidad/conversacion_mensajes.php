<?php //header('Content-Type: text/html; charset=iso-8859-1');
date_default_timezone_set('America/Mexico_City');
include_once('../../adodb/adodb.inc.php');
include_once('../Sentencias.php');
$query = new Sentencias();

$id = $_GET['id'];
$tpr = $_GET['tpr'];
$inst = $_GET['ins'];
echo "<div style='width:80%;height:18px; margin-top:18px; background:#BF1E2E;font-weight:bold; color:#FFF ;align:center;-moz-border-radius: 5px;-webkit-border-radius:5px;border-radius:5px;'>_Informaci&oacute;n de la Conversaci&oacute;n ".number_format($id)."</div>";
	$campos="TO_CHAR(cnv.\"INICIO\", 'HH24:MI:SS') as \"INICIO\", TO_CHAR(cnv.\"FIN\", 'HH24:MI:SS') as \"FIN\", us.\"NOMBRE\", us.\"CORREO\", op.\"NOMBRE\" as \"OPERADOR\", op.\"LOGIN\", op.\"PSEUDONIMO\", cnv.\"IP\" as \"IP\", cnv.\"SO\" as \"SO\", cnv.\"DISPOSITIVO\" as \"DISPOSITIVO\", cnv.\"NAVEGADOR\" as \"NAVEGADOR\", cnv.\"VERSION\" as \"VERSION\", cnv.\"ID_CONVERSACION\", TO_CHAR(cnv.\"INICIO\", 'YYYY-MM-DD') as FECHA, op.\"ID_OPERADOR\" , TO_CHAR((cnv.\"FIN\" - cnv.\"INICIO\"),'HH24:MI') as \"TIEMPO\"";
	$tablas="\"CHAT_CONVERSACIONES\" cnv, \"CHAT_USUARIOS\" us, \"CHAT_OPERADORES\" op";
	$criterios ="cnv.\"ID_USUARIO\" = us.\"ID_USUARIO\" and cnv.\"ID_OPERADOR\" = op.\"ID_OPERADOR\" and cnv.\"ID_CONVERSACION\"=".$id;
	$rs = $query->Consultar($query,$campos,$tablas,$criterios,"");
	$ini = $rs->fields['INICIO'];
	$fin = $rs->fields['FIN'];
	$usuario = $rs->fields['NOMBRE'];
	$correo = $rs->fields['CORREO'];
	$operador = $rs->fields['OPERADOR']." (".$rs->fields['LOGIN'].")";
	$op = $rs->fields['PSEUDONIMO'];	
	$ip = $rs->fields['IP'];	
	$so = $rs->fields['SO'];
	$id_cnv = $rs->fields['ID_CONVERSACION'];
	$navegador = $rs->fields['NAVEGADOR']." ".$rs->fields['VERSION'];	
	$dispositivo = ($rs->fields['DISPOSITIVO']==0?"":($rs->fields['DISPOSITIVO']==1?"Desktop":($rs->fields['DISPOSITIVO']==2?"Tablet":"Movil")));
	$fecha = $rs->fields['FECHA'];
	$id_op = $rs->fields['ID_OPERADOR'];
	$time = $rs->fields['TIEMPO'];
	if($rs->fields['TIEMPO']!=""){
		$time = str_replace('+000000000 ','',$time);
		$time_split = explode('.',$time);
		$time = $time_split[0];	
	}
	
	
	if($tpr==3){
		$rs_calidad = $query->Consultar($query,"ID_TEMA,ID_SUBTEMA,ID_ASUNTO,RESPUESTA,COMENTARIO","CHAT_CALIDAD","ID_CONVERSACION=".$id,"");
		$tp = $rs_calidad->RecordCount();
		$tm = $rs_calidad->fields['ID_TEMA'];
		$stm = $rs_calidad->fields['ID_SUBTEMA'];
		$asn = $rs_calidad->fields['ID_ASUNTO'];
		$res = $rs_calidad->fields['RESPUESTA'];
		$com = $rs_calidad->fields['COMENTARIO'];
	}
	
	echo "<table border='0' style='color:#BF1E2E; font-size:12px;width:600px;' align='center'>";
	echo "<tr><td><strong>Hora Inicio: </strong> $ini</td><td><strong>Hora Fin: </strong> $fin</td></tr>";	
	echo "<tr><td><strong>Operador: </strong> $operador</td><td><strong>Pseudonimo: </strong> $op</td></tr>";	
	echo "<tr><td><strong>Usuario: </strong> $usuario</td><td><strong>Correo: </strong>$correo</td></td></tr>";
	echo "<tr><td><strong>IP: </strong> $ip</td><td><strong>Dispositivo: </strong>$dispositivo</td></tr>";
	echo "<tr><td><strong>S.O.: </strong> $so</td><td><strong>Navegador: </strong> $navegador</td></tr>";	
	echo "</table>";
	if($tpr==3){
		echo "<br /><table style='width:600px;color:#BF1E2E; font-size:12px;'><tr>";
		echo "<tr align='center'><td><strong>Tema</strong></td><td><strong>Sub-Tema</strong></td><td><strong>Asunto</strong></td><td><strong>Respuesta</strong></td><td><strong>Comentario</strong></td><td></td></tr>";
		echo "<tr><td><select id='cmbtema' class='select' style='width:120px' onchange=\"Subtema(1,'dsubtema')\"><option value=0>Seleccione el Tema</option>";
		if ($inst == 1) {
			$rs_tema = $query->Consultar($query,"\"ID_TEMA\", \"DESCRIPCION\"","\"CHAT_TEMA\"","\"ID_INSTITUCION\" = 1 AND \"ID_TEMA\" > 0","\"ID_TEMA\"");
		}
		if ($inst == 2) {
			$rs_tema = $query->Consultar($query,"\"ID_TEMA\", \"DESCRIPCION\"","\"CHAT_TEMA\"","\"ID_INSTITUCION\" = 2 ","\"ID_TEMA\"");
		}
		while(!$rs_tema->EOF){
			$selected = ($tp>0?($tm==$rs_tema->fields['ID_TEMA']?"selected":""):"");
			echo "<option value=".$rs_tema->fields['ID_TEMA']." $selected>".$rs_tema->fields['DESCRIPCION']."</option>";
			$rs_tema->MoveNext();
		}
		echo "</select></td>";
		echo "<td><div id='dsubtema'><select id='cmbsubtema' class='select' style='width:120px'><option value=0>Seleccione el Subtema</option>";
		if($tp>0){
			$rs_subtema = $query->Consultar($query,"\"ID_SUBTEMA\", \"DESCRIPCION\"","\"CHAT_SUBTEMA\"","\"ID_SUBTEMA\">0 AND \"ID_TEMA\"=".$tm,"\"ID_SUBTEMA\"");
			while(!$rs_subtema->EOF){
				$selected = ($tp>0?($stm==$rs_subtema->fields['ID_SUBTEMA']?"selected":""):"");
				echo "<option value=".$rs_subtema->fields['ID_SUBTEMA']." $selected>".$rs_subtema->fields['DESCRIPCION']."</option>";
				$rs_subtema->MoveNext();
			}	
		}
		echo "</select></div></td>";
		echo "<td><div id='dasunto'><select id='cmbasunto' class='select' style='width:120px'><option value=0>Seleccione el Asunto</option>";
		if($tp>0){
			$rs_asunto = $query->Consultar($query,"\"ID_ASUNTO\", \"DESCRIPCION\"","\"CHAT_ASUNTO\"","\"ID_ASUNTO\">0 AND \"ID_TEMA\"=".$tm." AND \"ID_SUBTEMA\"=".$stm,"\"DESCRIPCION\"");
			while(!$rs_asunto->EOF){
				$selected = ($tp>0?($asn==$rs_asunto->fields['ID_ASUNTO']?"selected":""):"");
				echo "<option value=".$rs_asunto->fields['ID_ASUNTO']." $selected>".$rs_asunto->fields['DESCRIPCION']."</option>";
				$rs_asunto->MoveNext();
			}	
		}
		echo "</select></div></td>";
		echo "<td><select id='cmbrespuesta' class='select' style='width:120px'><option value=0>Seleccione la Respuesta</option><option value=1 ".($res==1?"selected":"").">Satisfactoria</option><option value=2  ".($res==2?"selected":"").">No Satisfactoria</option></select></td>";
		echo "<td><select id='cmbcomentario' class='select' style='width:120px'><option value=0>Seleccione el Comentario</option><option value=1 ".($com==1?"selected":"").">Operador no recibi&oacute; respuesta por parte del usuario</option><option value=2 ".($com==2?"selected":"").">Operador solicit&oacute; al usuario que se comunique con &aacute;rea correspondiente</option><option value=3 ".($com==3?"selected":"").">Usuario no recibi&oacute; respuesta por parte del operador</option><option value=4 ".($com==4?"selected":"").">Usuario termin&oacute; sesi&oacute;n</option></select></td>";
		echo "<td><a href='#'><img src='images/save.png' alt='Registrar Datos' title='Registrar Datos' onclick=\"Cambio(".$id.",".$tp.")\" /></a></td>";
		echo "</tr></table>";
	}
	
	$tabla = ($fecha==date('Y-m-d')?"\"CHAT_MENSAJES_NEW\"":"\"CHAT_MENSAJES\"");
	$orden = ($fecha==date('Y-m-d')?"\"ID_MENSAJE_NEW\"":"\"ID_MENSAJE\"");
	$rs = $query->Consultar($query,"TO_CHAR(\"SENT\", 'HH24:MI:SS') as \"SENT\", \"FROMM\", \"MESSAGE\", \"RECD\"",$tabla,"\"ID_CONVERSACION\"=".$id,$orden);	
	if($rs->RecordCount()>0){
		echo "<table style='width:95%; font-size:12px;' cellpadding='3' cellspacing='3'><tr style='font-weight:bold; color:#FFF; background: #BF1E2E;'>";		
		echo "<td align='center' style='-moz-border-radius:5px; -webkit-border-radius:5px; border-radius:5px;width:2%'></td>";
		echo "<td align='center' style='-moz-border-radius:5px; -webkit-border-radius:5px; border-radius:5px;'>Hora</td>";
		echo "<td align='center' style='-moz-border-radius:5px; -webkit-border-radius:5px; border-radius:5px;'>Usuario</td>";
		echo "<td align='center' style='-moz-border-radius:5px; -webkit-border-radius:5px; border-radius:5px;width:75%'>Mensaje</td></tr>";
		while(!$rs->EOF){	
			$recibido = $rs->fields['RECD'];
			$titulo = ($recibido==1?"Mensaje Recibido":($recibido==0?"Mensaje No Recibido":""));
			$cadena = "<img src='images/".($recibido==1?"msj_recibido":($recibido==0?"msj_norecibido":"")).".png' alt='".$titulo."' title='".$titulo."'/>";					
			
			echo "<tr ".($op==$rs->fields['FROMM']?"style='color:#133575;font-weight:bold;'":"style='color:black;'")."><td>".$cadena."</td><td>".$rs->fields['SENT']."</td><td>".$rs->fields['FROMM']."</td><td>".$rs->fields['MESSAGE']."</td></tr>";
			$rs->MoveNext();
		}
		echo "</table>";
	}
	echo "<br /><br />";
	echo "<input id='id_cnv' type='hidden' value='".$id."'/>";
	echo "<input id='cnv_fecha' type='hidden' value='".$fecha."'/>";
	echo "<input id='id_op' type='hidden' value='".$id_op."'/>";
	echo "<input id='hinicio' type='hidden' value='".$ini."'/>";
	echo "<input id='hfin' type='hidden' value='".$fin."'/>";
	echo "<input id='hduracion' type='hidden' value='".$time."'/>";
?>

