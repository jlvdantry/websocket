<?php	date_default_timezone_set('America/Mexico_City');
	$fch = ($_GET['fch']==""?date('Y-m-d'):date('Y-m-d',strtotime($_GET['fch'])));
	$tfch = ($fch == date('Y-m-d')?1:0);
	$id_ins = $_GET['inst'];
	$pr = $_GET['perfil'];
	$value = ($id_ins==1?'Informativos':($id_ins==2?'Psicologia':($id_ins==4?'Emergencias C5':'')));

	include_once('../adodb/adodb.inc.php');
	include_once('Sentencias.php');
	$query = new Sentencias();
	$status = array("desconectado","disponible","conversacion","pause","desconectado");
	$criterio = ($pr!=4?"\"STATUS\">-1 AND \"PERFIL\"=1 AND \"ID_INSTITUCION\"=".$id_ins:"\"PERFIL\"<=3 AND \"STATUS\">-1 AND \"ID_INSTITUCION\"=".$id_ins." ");
	$rs = $query->Consultar($query,"\"ID_OPERADOR\", \"NOMBRE\", \"LOGIN\", \"PERFIL\", \"ID_INSTITUCION\", CASE WHEN \"STATUS\"=4 THEN 0 ELSE \"STATUS\" END AS \"STATUS\"","\"CHAT_OPERADORES\"",$criterio,"\"STATUS\" DESC,\"ID_INSTITUCION\",\"PERFIL\", \"ID_OPERADOR\"");
	echo "<div style='width:300px; margin-top:45px; float:left; margin-left:35px;'>";
	//echo "<table style='width:300px'></table>";
	echo "<table style='width:300px;margin-top:20px;'>";
	echo "<tr><td colspan=2 align='center' style='font-weight:bold; -moz-border-radius:3px; -webkit-border-radius:3px; border-radius:3px;font-size:14px;background-color:#B61B1C;background-image:-webkit-gradient(linear,50% 0,50% 100%,color-stop(20%,#B61B1C),color-stop(90%,#F83437));background-image:-webkit-linear-gradient(#B61B1C 20%,#F83437 90%);background-image:-moz-linear-gradient(#B61B1C 20%,#F83437 90%);background-image:-o-linear-gradient(#B61B1C 20%,#F83437 90%);background-image:linear-gradient(#B61B1C 20%,#F83437 90%);color:#fff;'>Operadores</td></tr>";
	echo "<tr><td colspan=2><input id='tfch' type='hidden' value='".$tfch."'/><input type='text' id='DTFecha' class='edit' readonly='readonly' value='$fch' /></td></tr>";
	if($pr >= 3){
	echo "<tr><td colspan='2'><select id='typeChat' class='select' onchange=\"ChangeId()\"><option value='0'>Selecciona el Chat</option><option value='1' ".($id_ins==1?"selected":"").">Informativos</option><option value='3' ".($id_ins==3?"selected":"").">Jur&iacute;dico</option><option value='5' ".($id_ins==5?"selected":"").">M&eacute;dico</option><option value='2' ".($id_ins==2?"selected":"").">Psicolog&iacute;a</option><option value='4' ".($id_ins==4?"selected":"").">Emergencias C5</option><option value='6' ".($id_ins==6?"selected":"").">Redes Sociales</option></select></td></tr>";}
	while(!$rs->EOF){
		$titulo = "alt='".ucfirst($status[$rs->fields['STATUS']])."' title='".ucfirst($status[$rs->fields['STATUS']])."'";
		echo "<tr valign='middle'>";

		if($rs->fields['PERFIL']==1)
			$icono = "op_";
		else if($rs->fields['PERFIL']==2)
			$icono = "sp_";
		else if($rs->fields['PERFIL']==3)
			$icono = "cd_";

		$imagen = ($fch==date('Y-m-d')?"<img id='img_op_".$rs->fields['ID_OPERADOR']."' src='images/".$icono.$status[$rs->fields['STATUS']].".png' $titulo />":"<img src='images/op_anterior.png' />");
		if($rs->fields['STATUS']>0 && $fch==date('Y-m-d'))
			echo "<td align='center'><a href='#' onclick='Desactiva_Operador(".$rs->fields['ID_OPERADOR'].",\"".$rs->fields['LOGIN']."\",".$pr."); return false;'>".$imagen."</a></td>";
		else
			echo "<td align='center'>".$imagen."</td>";

		if($rs->fields['ID_INSTITUCION']==1)
			$color = "color:#000";
		else
			$color = "color:#FF0000";

		if($rs->fields['PERFIL']==1)
			$mostrar_conversacion = "<td align='left'><a href='#' style='font-size:14px;".$color."' onclick=\"Mostrar_Conversacion(".$rs->fields['ID_OPERADOR'].",'".$fch."'); return false;\">".$rs->fields['NOMBRE']."</a>";
		else
			$mostrar_conversacion = "<td align='left' style='font-size:14px;".$color."'>".$rs->fields['NOMBRE'];

		echo $mostrar_conversacion."</td></tr>";
		echo "<tr><td></td><td><div id='op".$rs->fields['ID_OPERADOR']."'></div></td></tr>";
		$cadena = ($cadena==""?$rs->fields['ID_OPERADOR']:$cadena."|".$rs->fields['ID_OPERADOR']);
		$rs->MoveNext();
	}
	echo "</table><input type='hidden' id='op_tot' value=$cadena /><br /><br /><br /></div>";
	echo "<div id='conversacion_mensajes' style='float:left; width:650px; margin-top:50px;'></div>";
?>
