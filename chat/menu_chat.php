<?php /*ini_set("session.cookie_lifetime", 28800);
	  ini_set("session.gc_maxlifetime", 28800);*/
	  session_start();
	  header('Content-Type: text/html; charset=iso-8859-1');
	  $nom_op = $_SESSION['nombre'];$log_op = $_SESSION['login'];$inicio = $_SESSION['inicio'];
	  $pr = $_GET['perfil'];
	  $ins = $_GET['inst'];
?>
<div id='cssmenu'>
<input type="hidden" id="tp_perfil" value="<?php echo $pr;?>" />
<ul>
<?php if($pr==2 || $pr==4){?>
   <li id='li_monitoreo' value="1"><a href='#' onClick="originalId(); Status_Automatico(<?php echo $pr;?>); $('#tp_seccion').val(1);">Monitoreo</a></li>
<?php }?>
   <li id='li_calidad' value="2"><a href='#' onClick=" originalId(); Limpiar_Intervalos(); Calidad('calidad/conversaciones.php','fch=<?php echo date('Y-m-d');?>&inst='+id_institucion.value+'&tpr='+tp_perfil.value,'Principal'); $('#tp_seccion').val(2);">Conversaciones</a></li>
   <li id='li_reportes' value="3"><a href='#' onClick="originalId(); Limpiar_Intervalos(); ajax('reportes.php?tpr='+tp_perfil.value,'Principal',1);">Reportes</a></li>
<?php if($ins==1 || $ins==4){?>
   <!--<li id='li_conocimiento'><a href='#' onClick="Limpiar_Intervalos(); Ajax_Dinamico('ayuda2.php','Principal','cat=categorias&op=');">Conocimientos</a></li>-->
   <li id='li_conocimiento' value="4"><a href='#' onClick="originalId(); Limpiar_Intervalos(); ajax('ayuda.php?inst=<?php echo $ins;?>','Principal',1);$('#tp_seccion').val(4);">Conocimientos</a></li>
<?php }?>
   <li><a href='#' onClick="Cerrar_Sesion();">Salir</a></li>
</ul>
</div>
<br  />
<div id="Principal" style="width:1000px;"></div>
<div align="center" class='footer' style="color:white;">
<table border="0" style="width:100%;">
<tr>
<td align="left" width="75%" style="color:white; font-size:12px;">Bienvenido: <?php echo $nom_op;?></td>
<?php
if($pr == 1){$tp = 'Operador';}
if($pr == 2){$tp = 'Supervisor';}
if($pr == 3){$tp = 'Calidad';}
if($pr == 4){$tp = 'Administrador';}?>
<td align="right" width="25%" style="color:white; font-size:12px;">Tipo de Usuario: <?php echo $tp;?> </td>
</tr>
</table>
</div>