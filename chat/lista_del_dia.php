<?php date_default_timezone_set('America/Mexico_City');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$inst = $_POST['inst'];
echo "<img src='images/fancy_close.png' alt='Cerrar' title='Cerrar' style='cursor:pointer; cursor:hand; right:-14px; top:-14px; position:fixed;' onClick=\"Ocultar();\"  />";
echo "<div style='width:80%;height:18px; margin-top:10px; background:#BF1E2E;font-weight:bold; color:#FFF ;align:center;-moz-border-radius: 5px;-webkit-border-radius:5px;border-radius:5px;'>".($_POST['tp']==1?"Conversaciones Atendidas ":"Lista de Abandonos ").date('d-m-Y')."</div><br /><br />";
	include_once('../adodb/adodb.inc.php');
	include_once('Sentencias.php');
	include_once('constantes.php');

	$query = new Sentencias();

        echo "entro";
	if($_POST['tp']==1){//Atendidos
		$campos = "cnv.\"ID_CONVERSACION\" AS \"CVE\", TO_CHAR(cnv.\"INICIO\", 'HH24:MI:SS') AS \"INICIO\", TO_CHAR(cnv.\"FIN\", 'HH24:MI:SS') AS \"FIN\", TO_CHAR((cnv.\"FIN\" - cnv.\"INICIO\"),'HH24:MI') as \"TIEMPO\", cnv.\"ID_ESPERA\" as \"ID_ESPERA\", TO_CHAR((esp.\"ATENCION\" - esp.\"ENTRADA\"),'HH24:MI') as \"ESPERA\"";
		$tablas = "\"CHAT_CONVERSACIONES\" cnv, \"CHAT_ESPERA\" esp";
		$criterio = "cnv.\"ID_ESPERA\" = esp.\"ID_ESPERA\" AND to_char(cnv.\"INICIO\", 'yyyy-mm-dd')='".date('Y-m-d')."' AND cnv.\"FIN\" IS NOT NULL AND cnv.\"ID_INSTITUCION\"=".$inst;
		$orden = "cnv.\"ID_CONVERSACION\"";
	}else{//Abandonos
		$campos = "\"NOMBRE\", TO_CHAR(\"ENTRADA\", 'HH24:MI:SS') AS \"INICIO\",TO_CHAR(\"ATENCION\", 'HH24:MI:SS') AS \"FIN\", TO_CHAR((\"ATENCION\" - \"ENTRADA\"),'HH24:MI') AS \"TIEMPO\"";
		$tablas = "\"CHAT_ESPERA\"";
		$criterio = "\"STATUS\"=1 AND to_char(\"ATENCION\", 'yyyy-mm-dd')='".date('Y-m-d')."' AND \"ID_INSTITUCION\"=".$inst." and datediff('SS',\"ATENCION\",current_timestamp::timestamp(0))>".INA_MAX;
		$orden = "\"ID_ESPERA\"";
	}
        echo "antes consultar";
	$rs = $query->Consultar($query,$campos,$tablas,$criterio,$orden);
        echo "paso consultar";
	if($rs->RecordCount()>0){
		echo "<div class='lista' style='overflow-y:auto; width:95%; height:520px'><table class='tabla' style='width:70%;-moz-border-radius: 5px; -webkit-border-radius: 5px; border-radius: 5px;'>";
		echo "<tr class='tabla_cabecera'>";
		echo "<td>##</td>";
		echo "<td>".($_POST['tp']==1?"Conversaci&oacute;n":"Nombre")."</td>";
		echo ($_POST['tp']==1?"<td>Espera</td>":"");
		echo "<td>Inicio</td>";
		echo "<td>".($_POST['tp']==1?"Fin":"Abandono")."</td>";
		echo "<td>Tiempo</td></tr>";
		$contador = 1;
		while(!$rs->EOF){
			$time = "";
			$time = $rs->fields['TIEMPO'];
			if($time!=""){
				//$time = str_replace('+000000000 ','',$time);
				$time_split = explode(' ',$time);
				$time_split2 = explode(':',$time_split[1]);
				$time = $time_split2[0];
			}
			$time = ($time!=""?$time:"");

			$estilo = "";
			if($contador%2==0){
				$estilo = "background-color:#FFFFBA;";
			}

			$time2 = "";
			if($_POST['tp']==1){
				if($rs->fields['ID_ESPERA']!=0){
					if($estilo!="")
						$estilo = $estilo."color:red; font-weight:bold;";
					else
						$estilo = "color:red; font-weight:bold;";
				}

				$time2 = $rs->fields['ESPERA'];
				if($time2!=""){
					$time2_split = explode(' ',$time2);
					$time2_split2 = explode(':',$time2_split[1]);
					$time2 = $time2_split2[0];
				}

				//$time2 = ($time2!=""?$time2:"");
			}

			echo "<tr align='center' ".($estilo!=""?"style='".$estilo."'":"").">";
			echo "<td>".$contador."</td>";
			echo "<td>".($_POST['tp']==1?number_format($rs->fields['CVE']):$rs->fields['NOMBRE'])."</td>";
			echo ($_POST['tp']==1?"<td>".$rs->fields['ESPERA']."</td>":"");
			echo "<td>".$rs->fields['INICIO']."</td>";
				echo "<td>".$rs->fields['FIN']."</td>";
			echo "<td>".$rs->fields['TIEMPO']."</td></tr>";
			$rs->MoveNext();
			$contador++;
		}
		echo "</table></div>";
	}
?>
