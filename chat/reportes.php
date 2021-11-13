<?php 
$perfil = $_GET['tpr'];	
	echo "<div style='width:250px; margin-top:60px; float:left; border-right: dashed red 2px; height:78%;'>";
	echo "<strong style='font-size:14px; margin-left:-30px;'>Reportes y Gr&aacute;ficas</strong>";
	echo "<table cellspacing='8' style='margin-left:10px; margin-top:7px'>";	
	echo "<tr><td><a href='#' style='font-size:14px' onclick=\"Limpiar_Intervalos();originalId();Ajax_Jquery('total','','reporte_principal');$('#tp_seccion').val(3);\"><strong>Total Diario</strong></a></td></tr>";
	echo "<tr><td><a href='#' style='font-size:14px' onclick=\"Limpiar_Intervalos();originalId();Ajax_Jquery('Gconversaciones','Acumulado','reporte_principal');$('#tp_seccion').val(4);\"><strong>Gr&aacute;fico Acumulado</strong></a></td></tr>";
	echo "<tr><td><a href='#' style='font-size:14px' onclick=\"Limpiar_Intervalos();originalId();Ajax_Jquery('Gconversaciones','X_Hora','reporte_principal');$('#tp_seccion').val(5);\"><strong>Gr&aacute;fico del D&iacute;a Por Hora</strong></a></td></tr>";
	if($_GET['tpr']>=3){
	echo "<tr><td><a href='#' style='font-size:14px' onclick=\"Limpiar_Intervalos();originalId();Calidad('calidad/reporte.php','fi=&ff=','reporte_principal');$('#tp_seccion').val(6);\"><strong>Reporte de Calidad</strong></a></td></tr>";
	}
	echo "</table></div>";
	echo "<div id='reporte_principal' align='center' style='float:left; width:700px; margin-top:50px; border:solid red 0px;'></div>";
?>
