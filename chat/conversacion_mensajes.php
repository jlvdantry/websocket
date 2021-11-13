<?php //header('Content-Type: text/html; charset=iso-8859-1');
date_default_timezone_set('America/Mexico_City');
$id = $_GET['id'];
echo "<img src='images/fancy_close.png' alt='Cerrar' title='Cerrar' style='cursor:pointer; cursor:hand; right:-14px; top:-14px; position:fixed;' onClick=\"Ocultar();clearInterval($('#Interval_id').val());\"  />";
echo "<div style='width:80%;height:18px; margin-top:10px; font-weight:bold; align:center;-moz-border-radius: 5px;-webkit-border-radius:5px;border-radius:5px; background-color:#B61B1C;background-image:-webkit-gradient(linear,50% 0,50% 100%,color-stop(20%,#B61B1C),color-stop(90%,#F83437));background-image:-webkit-linear-gradient(#B61B1C 20%,#F83437 90%);background-image:-moz-linear-gradient(#B61B1C 20%,#F83437 90%);background-image:-o-linear-gradient(#B61B1C 20%,#F83437 90%);background-image:linear-gradient(#B61B1C 20%,#F83437 90%);color:#fff;'>Informaci&oacute;n de la Conversaci&oacute;n ".number_format($id)."</div>";
	
	include_once('../adodb/adodb.inc.php');
	include_once('Sentencias.php');
	$query = new Sentencias();
	$campos="TO_CHAR(cnv.INICIO, 'HH24:MI:SS') as INICIO, TO_CHAR(cnv.FIN, 'HH24:MI:SS') as FIN, us.NOMBRE, us.CORREO, op.NOMBRE as OPERADOR, op.LOGIN, op.PSEUDONIMO, cnv.IP as IP, cnv.so as SO, cnv.dispositivo as DISPOSITIVO, cnv.navegador as NAVEGADOR, cnv.version as VERSION, cnv.ID_CONVERSACION, TO_CHAR(cnv.INICIO, 'YYYY-MM-DD') as FECHA";
	$tablas="CHAT_CONVERSACIONES cnv, CHAT_USUARIOS us, CHAT_OPERADORES op";
	$criterios ="cnv.ID_USUARIO = us.ID_USUARIO and cnv.ID_OPERADOR = op.ID_OPERADOR and cnv.ID_CONVERSACION=".$id;
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

	echo "<table style='color:#BF1E2E; font-size:12px;width:600px;' align='center'>";
	echo "<tr><td><strong>Hora Inicio: </strong> $ini</td><td><strong>Hora Fin: </strong> $fin</td></tr>";	
	echo "<tr><td><strong>Operador: </strong> $operador</td><td><strong>Pseudonimo: </strong> $op</td></tr>";	
	echo "<tr><td><strong>Usuario: </strong> $usuario</td><td><strong>Correo: </strong>$correo</td></td></tr>";
	echo "<tr><td><strong>IP: </strong> $ip</td><td><strong>Dispositivo: </strong>$dispositivo</td></tr>";
	echo "<tr><td><strong>S.O.: </strong> $so</td><td><strong>Navegador: </strong> $navegador</td></tr>";	
	echo "</table>";
	/*echo "<tr><td colspan=2>";
	echo "<select class='select'><option value=0>Seleccione el Tema</option></select>";
	echo "<select class='select'><option value=0>Seleccione el Subtema</option></select>";
	echo "<select class='select'><option value=0>Seleccione el Asunto</option></select>";
	echo "<select class='select'><option value=0>Seleccione la Respuesta</option></select>";
	echo "<select class='select'><option value=0>Seleccione el Comentario</option></select>";
	echo "</td></tr>";*/
	
	$tabla = ($fecha==date('Y-m-d')?"CHAT_MENSAJES_NEW":"CHAT_MENSAJES");
	$orden = ($fecha==date('Y-m-d')?"ID_MENSAJE_NEW":"ID_MENSAJE");
	$rs = $query->Consultar($query,"TO_CHAR(SENT, 'HH24:MI:SS') as SENT, FROMM, MESSAGE, RECD",$tabla,"ID_CONVERSACION=".$id,$orden);	
	if($rs->RecordCount()>0){
		// style='overflow:auto; height:450px;'
		//echo "<div id='sc_mensajes' style='overflow:auto; height:450px;'>";
		echo "<div class='scrollingtable'><div><div><table style='font-size:12px;'><thead><tr><th><div label=' '/></th><th><div label='Hora' /></th><th><div label='Usuario'/></th><th><div><div>Mensaje</div><div>Mensaje</div></div></th><th class='scrollbarhead'/></tr></thead><tbody>";
		/*echo "<table style='width:95%; font-size:12px;' cellpadding='3' cellspacing='3'><tr style='font-weight:bold; color:#FFF; background: #BF1E2E;'>";		
		echo "<td align='center' style='-moz-border-radius:5px; -webkit-border-radius:5px; border-radius:5px;'></td>";
		echo "<td align='center' style='-moz-border-radius:5px; -webkit-border-radius:5px; border-radius:5px;'>Hora</td>";
		echo "<td align='center' style='-moz-border-radius:5px; -webkit-border-radius:5px; border-radius:5px;'>Usuario</td>";
		echo "<td align='center' style='-moz-border-radius:5px; -webkit-border-radius:5px; border-radius:5px;'>Mensaje</td></tr>";			*/
		$contador=1;
		while(!$rs->EOF){	
			$recibido = $rs->fields['RECD'];
			$titulo = ($recibido==1?"Mensaje Recibido":($recibido==0?"Mensaje No Recibido":""));
			$cadena = "<img src='images/".($recibido==1?"msj_recibido":($recibido==0?"msj_norecibido":"")).".png' alt='".$titulo."' title='".$titulo."'/>";	
				
			if($contador==1)	
				$user_msg =  $rs->fields['FROMM'];
			
			echo "<tr ".($user_msg!=$rs->fields['FROMM']?"style='color:#133575;font-weight:bold;'":"style='color:black;'")."><td>".$cadena."</td><td>".$rs->fields['SENT']."</td><td>".$rs->fields['FROMM']."</td><td>".$rs->fields['MESSAGE']."</td></tr>";
			$rs->MoveNext();
			$contador++;
		}
		echo "</tbody></table></div></div></div>";
	}
	echo "<br /><br />";
?>
