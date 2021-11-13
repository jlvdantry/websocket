<?php date_default_timezone_set('America/Mexico_City'); header('Content-Type: text/html; charset=iso-8859-1');
	$fch = ($_GET['fch']==""?date('Y-m-d'):date('Y-m-d',strtotime($_GET['fch'])));
	$tpr = $_GET['tpr'];
	$ins = $_GET['inst'];
			
	include_once('../../adodb/adodb.inc.php');
	include_once('../Sentencias.php');
	$query = new Sentencias();
	$rs = $query->Consultar($query,"\"ID_CONVERSACION\", \"ID_ESPERA\", (select count(*)from \"CHAT_CALIDAD\" where \"ID_CONVERSACION\"=\"CHAT_CONVERSACIONES\"".
                ".\"ID_CONVERSACION\") as  \"REVISADO\"","\"CHAT_CONVERSACIONES\"","TO_CHAR(\"INICIO\", 'YYYY-MM-DD')='".$fch."' AND \"ID_INSTITUCION\"=".$ins,"\"INICIO\"");
	echo "<div style='margin-left:33px; margin-top:47px; float:left;border-right: 2px dashed #BF1E2E'>";
	echo "<table border='0' style='font-size:12px; width:150px'>";
	echo "<tr><td colspan=2><input id='tfch' type='hidden' value='".$fch."'/><input type='text' id='DTFecha' class='edit' readonly='readonly' value='$fch' style='width:120px'/></td></tr>";
	if($tpr >= 3){
	echo "<tr><td colspan='2'><select id='typeChat' onchange='ChangeId()' style='width:135px; border-radius:4px; box-shadow: 2px 2px 1px #888888;'><option value='0' selected>Seleccione el Chat</option><option value='1' ".($ins==1?"selected":"").">Informativos</option><option value='3' ".($ins==3?"selected":"").">Jur&iacute;dico</option><option value='5' ".($ins==5?"selected":"").">M&eacute;dico</option><option value='2' ".($ins==2?"selected":"").">Psicolog&iacute;a</option><option value='4' ".($ins==4?"selected":"").">911 CDMX</option><option value='6' ".($ins==6?"selected":"").">Redes Sociales</option></select></td></tr>";}
	if($rs->RecordCount()>0){				
		echo "<tr><td align='center' colspan=2 style='font-weight:bold;-moz-border-radius:3px; -webkit-border-radius:3px; border-radius:3px; background-color:#B61B1C;background-image:-webkit-gradient(linear,50% 0,50% 100%,color-stop(20%,#B61B1C),color-stop(90%,#F83437));background-image:-webkit-linear-gradient(#B61B1C 20%,#F83437 90%);background-image:-moz-linear-gradient(#B61B1C 20%,#F83437 90%);background-image:-o-linear-gradient(#B61B1C 20%,#F83437 90%);background-image:linear-gradient(#B61B1C 20%,#F83437 90%);color:#fff;'>".$rs->RecordCount().($rs->RecordCount()==1?"  Conversaci&oacute;n":" Conversaciones")."</td></tr>";
		$contador=1;
		while(!$rs->EOF){
			$color = ($rs->fields['ID_ESPERA']==0?"#000":"red");
			$img = ($tpr>=3?" <img id='img_".$rs->fields['ID_CONVERSACION']."' src='images/".($rs->fields['REVISADO']==1?"revisado":"sin_revisar").".png' /> ":"");
			echo "<tr>";
			echo "<td ".($tpr>=3?"width='45' ":"width='45' ")."align='right' style='color:".$color."'>".($tpr>=3?"<b>".$contador.".- </b>":"")."</td><td align='left'><a href='#' style='color:".$color."' onclick=\"Calidad('calidad/conversacion_mensajes.php','id=".$rs->fields['ID_CONVERSACION']."&tpr=".$tpr."&ins=".$ins."','dconversacion');\"><b>".$img.number_format($rs->fields['ID_CONVERSACION'])."</b></a></td></tr>";			
			$rs->MoveNext();
			$contador++;
		}		
	}

	echo "</table><br /><br /><br /></div>";
	echo "<div id='dconversacion' style='float:left; width:790px; margin-top:50px; padding:10px;'></div>";
?>
