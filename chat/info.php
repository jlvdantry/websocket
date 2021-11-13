<?php /*ini_set("session.cookie_lifetime", 28800);
	  ini_set("session.gc_maxlifetime", 28800);*/
	  session_start();
	  //header('Content-Type: text/html; charset=iso-8859-1');
	  $nom_op = $_SESSION['nombre'];$log_op = $_SESSION['login'];$inicio = $_SESSION['inicio'];?>
<table cellpadding="5">
<tr>
<td><div id='hold'><input type='hidden' id='tval' value='3' /><a href='#' onclick="Cambiar_Status()"><img id='tval_image' /></a></div></td>
<td><a href='#' onclick="Cerrar_Sesion()"><img src='images/chat_end.png' alt='Cerrar Sesi&oacute;n' title='Cerrar Sesi&oacute;n' /></a></td>
</table>
<div id="countdown" class="reloj_ubicacion" align="center"></div>

<table class='footer_operador' style="color:white; font-size:12px; font-weight:bold;">
<tr>
<td align="left" width="70%" style="padding-left:15px;">Bienvenido: <?php echo $nom_op;?></td>
<td align="right" width="30%" style="padding-right:15px;">Tipo de Usuario: Operador</td>
</tr>
</table>
