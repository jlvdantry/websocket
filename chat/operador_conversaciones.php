<?php date_default_timezone_set('America/Mexico_City'); header('Content-Type: text/html; charset=iso-8859-1');
	$op = $_GET['op'];
	$fch = $_GET['fecha'];
	include_once('../adodb/adodb.inc.php');
	include_once('Sentencias.php');
	$query = new Sentencias();
	$rs_op = $query->Consultar($query,"IP, NAVEGADOR","CHAT_OPERADORES","ID_OPERADOR=".$op,"");	
	$rs = $query->Consultar($query,"ID_CONVERSACION, TO_CHAR(INICIO, 'HH24:MI:SS') AS INICIO, TO_CHAR(FIN, 'HH24:MI:SS') AS FIN, TO_CHAR((FIN - INICIO),'HH24:MI') as TIEMPO, ID_ESPERA","CHAT_CONVERSACIONES","ID_OPERADOR=".$op." and to_char(INICIO, 'yyyy-mm-dd')='".$fch."'","INICIO");
	if($rs->RecordCount()>0){
		echo "<table style='margin-left:20px; font-size:13px'>";
		echo "<tr><td colspan=4 align='center' style='font-weight:bold; -moz-border-radius:3px; -webkit-border-radius:3px; border-radius:3px;background-color:#B61B1C;background-image:-webkit-gradient(linear,50% 0,50% 100%,color-stop(20%,#B61B1C),color-stop(90%,#F83437));background-image:-webkit-linear-gradient(#B61B1C 20%,#F83437 90%);background-image:-moz-linear-gradient(#B61B1C 20%,#F83437 90%);background-image:-o-linear-gradient(#B61B1C 20%,#F83437 90%);background-image:linear-gradient(#B61B1C 20%,#F83437 90%);color:#fff;'>".$rs_op->fields[0]." ".substr(str_replace("."," ",$rs_op->fields[1]),0,10)."</td></tr>";
		echo "<tr><td colspan='4' align='center' style='font-weight:bold; -moz-border-radius:3px; -webkit-border-radius:3px; border-radius:3px;background-color:#B61B1C;background-image:-webkit-gradient(linear,50% 0,50% 100%,color-stop(20%,#B61B1C),color-stop(90%,#F83437));background-image:-webkit-linear-gradient(#B61B1C 20%,#F83437 90%);background-image:-moz-linear-gradient(#B61B1C 20%,#F83437 90%);background-image:-o-linear-gradient(#B61B1C 20%,#F83437 90%);background-image:linear-gradient(#B61B1C 20%,#F83437 90%);color:#fff;'>".($rs->RecordCount()==1?$rs->RecordCount()." Conversaci&oacute;n":($rs->RecordCount()>1?$rs->RecordCount()." Conversaciones":""))."</td></tr>";
		echo "<tr><td align='center' style='width:30px;font-weight:bold; -moz-border-radius:3px; -webkit-border-radius:3px; border-radius:3px; background-color:#B61B1C;background-image:-webkit-gradient(linear,50% 0,50% 100%,color-stop(20%,#B61B1C),color-stop(90%,#F83437));background-image:-webkit-linear-gradient(#B61B1C 20%,#F83437 90%);background-image:-moz-linear-gradient(#B61B1C 20%,#F83437 90%);background-image:-o-linear-gradient(#B61B1C 20%,#F83437 90%);background-image:linear-gradient(#B61B1C 20%,#F83437 90%);color:#fff;'>####</td><td align='center' style='width:50px;font-weight:bold; -moz-border-radius:3px; -webkit-border-radius:3px; border-radius:3px; background-color:#B61B1C;background-image:-webkit-gradient(linear,50% 0,50% 100%,color-stop(20%,#B61B1C),color-stop(90%,#F83437));background-image:-webkit-linear-gradient(#B61B1C 20%,#F83437 90%);background-image:-moz-linear-gradient(#B61B1C 20%,#F83437 90%);background-image:-o-linear-gradient(#B61B1C 20%,#F83437 90%);background-image:linear-gradient(#B61B1C 20%,#F83437 90%);color:#fff;'>Inicio</td><td align='center' style='width:50px;font-weight:bold; -moz-border-radius:3px; -webkit-border-radius:3px; border-radius:3px; background-color:#B61B1C;background-image:-webkit-gradient(linear,50% 0,50% 100%,color-stop(20%,#B61B1C),color-stop(90%,#F83437));background-image:-webkit-linear-gradient(#B61B1C 20%,#F83437 90%);background-image:-moz-linear-gradient(#B61B1C 20%,#F83437 90%);background-image:-o-linear-gradient(#B61B1C 20%,#F83437 90%);background-image:linear-gradient(#B61B1C 20%,#F83437 90%);color:#fff;'>Fin</td><td align='center' style='width:60px;font-weight:bold; color:#FFF; -moz-border-radius:3px; -webkit-border-radius:3px; border-radius:3px; background: #BF1E2E;'>Duraci&oacute;n</td></tr>";
		while(!$rs->EOF){
			$tp = ($rs->fields['TIEMPO']==""?0:2);			
			$time = $rs->fields['TIEMPO'];
			if($rs->fields['TIEMPO']!=""){
				$time = str_replace('+000000000 ','',$time);
				$time_split = explode('.',$time);
				$time = $time_split[0];	
			}
			$time = ($time!=""?"(".$time.")":"");
			$color = ($rs->fields['ID_ESPERA']==0?"#000":"red");
			echo "<tr valign='top'>";
			echo "<td align='center'><a href='#' style='color:".$color."' onclick=\"Conversacion_Tiempo_Real(".$rs->fields['ID_CONVERSACION'].",$tp); return false;\"><b> ".$rs->fields['ID_CONVERSACION']."</b></a></td>";
			echo "<td><a href='#' style='color:".$color."' onclick=\"Conversacion_Tiempo_Real(".$rs->fields['ID_CONVERSACION'].",$tp); return false;\">".$rs->fields['INICIO']."</a></td>";
			echo "<td><a href='#' style='color:".$color."' onclick=\"Conversacion_Tiempo_Real(".$rs->fields['ID_CONVERSACION'].",$tp); return false;\">".$rs->fields['FIN']."</a></td>";
			echo "<td><a href='#' style='color:".$color."' onclick=\"Conversacion_Tiempo_Real(".$rs->fields['ID_CONVERSACION'].",$tp); return false;\">".$time."</a></td></tr>";
			$rs->MoveNext();
		}
		echo "</table>";
	}else
		echo "<div align='center' style='margin-left:25px; font-size:13px; margin-bottom:5px; font-weight:bold; color:#FFF; -moz-border-radius:3px; -webkit-border-radius:3px; border-radius:3px; background: #BF1E2E; width:180px'>".$rs_op->fields[0]." ".substr(str_replace("."," ",$rs_op->fields[1]),0,10)."<br>No tuvo conversaciones </div>";
		//ajax('conversacion_mensajes.php?id=".$rs->fields['id_conversacion']."','conversacion_mensajes',1)
?>