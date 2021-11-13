<?php //session_start(); session_destroy();?>
<!DOCTYPE>
<html>
<head>
<title>Chat</title>
<link rel="shortcut icon" type="image/png" href="images/favicon.ico"/>
<link href='images/favicon.ico' rel='shortcut icon' type='image/x-icon'/>
<link href='images/favicon.ico' rel='icon' type='image/x-icon'/>
<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
<meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1' />
<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
<meta http-equiv="Pragma" content="no-cache" />
<meta http-equiv="Expires" content="0" />
<link type="text/css" rel="stylesheet" media="all" href="estilo/menu.css" />
<link type="text/css" rel="stylesheet" media="all" href="estilo/chat_supervision_20170330.css" />
<link type="text/css" rel="stylesheet" media="all" href="estilo/screen.css" />
<link type="text/css" rel="stylesheet" media="all" href="estilo/sweetalert.css" />

<link href="calendarui/jquery-ui.css" media="screen" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="js/chat_locatel_20170406.js"></script>
<script type="text/javascript" src="js/supervision_locatel_20170330.js"></script>
<script type="text/javascript" src="js/chat_locatel_20170407_redes.js"></script>
<script src="calendarui/jquery-ui.js"></script>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript">google.load("visualization", "1", {packages:["corechart"]});</script>
<script src="js/sweetalert.min.js"></script>

<style>
a:link{text-decoration: none;color:#E71D25;}
a:visited{text-decoration: none;color:#E71D25;}
a:active{text-decoration: nonde; font-weight:bold;color:#E71D25;}
a:hover{text-decoration: none; color:green; text-shadow: 0px 0px 0px #37070c;}

.treeviewFolderPrin{list-style-type:none;font-size:12px;vertical-align:middle;font-weight:bold;color:#E71D25;}
.treeviewFolderLi{list-style-type:none;font-size:12px;vertical-align:middle;font-weight:bold;color:#E71D25;}

.info{
     background-color: #4ea5cd;
     border-color: #3b8eb5;
	 color: #000;
}

.error{
     background-color: #de4343;
     border-color: #c43d3d;
	 color: #FFF;
}

.warning{
     background-color: #DBAF51;
     border-color: #d99a36;
	 color: #000;
}

.success{
     background-color: #61b832;
     border-color: #55a12c;
	 color: #FFF;
}
.message h3{
     margin: 0 0 5px 0;
}

.message p{
     margin: 0;
}
.message{
    background-size: 40px 40px;
    background-image: linear-gradient(135deg, rgba(255, 255, 255, .05) 25%, transparent 25%,
                        transparent 50%, rgba(255, 255, 255, .05) 50%, rgba(255, 255, 255, .05) 75%,
                        transparent 75%, transparent);
     box-shadow: inset 0 -1px 0 rgba(255,255,255,.4);
     width: 250px;
     padding: 15px;
     position: absolute;
     _position: absolute;
	 top:70px;
	 left:30px;
     text-shadow: 0 1px 0 rgba(0,0,0,.25);
     animation: animate-bg 5s linear infinite;
	 -webkit-border-radius: 5px;
	 -moz-border-radius: 5px;
	 border-radius: 5px;
}
.boton{font-size:11px;font-weight:bolder; border:0px; width:100px;height:22px; -moz-border-radius: 5px; -webkit-border-radius: 5px; border-radius: 5px;  -moz-box-shadow: 2px 2px 3px #DEDFE0; -webkit-box-shadow: 2px 2px 3px #DEDFE0; box-shadow: 2px 2px 3px #DEDFE0; outline: 0; -webkit-appearance: none; cursor:pointer; cursor:hand;background-color:#B61B1C;background-image:-webkit-gradient(linear,50% 0,50% 100%,color-stop(20%,#B61B1C),color-stop(90%,#F83437));background-image:-webkit-linear-gradient(#B61B1C 20%,#F83437 90%);background-image:-moz-linear-gradient(#B61B1C 20%,#F83437 90%);background-image:-o-linear-gradient(#B61B1C 20%,#F83437 90%);background-image:linear-gradient(#B61B1C 20%,#F83437 90%);color:#fff;}
.boton:hover{color:#000;background:#BC1A29; border:1px solid black;}
input.edit{
	border: 1px solid #ccc;
	-moz-border-radius: 3px;
	-webkit-border-radius: 3px;
	border-radius: 3px;
	-moz-box-shadow: 2px 2px 3px #666;
	-webkit-box-shadow: 2px 2px 3px #666;
	box-shadow: 2px 2px 3px #666;
	font-size: 12px;outline: 0;
	-webkit-appearance: none;
	/*width:200px;*/
	width:180px;
	height:22px;
	padding-left:5px;
	text-transform:uppercase;
}
input.edit:focus{border: #B61B1C solid 2px;}
.lnk:link{text-decoration: none; color:black;}
.lnk:visited {text-decoration: none; color:black;}
.lnk:hover {color:#B61B1C;text-decoration:none;text-shadow: 5px 5px 5px #aaa;}
.lnk:active {text-decoration: none; color:black;}
</style>
<script>
function Nodo_Drill(categoria, padre, div) {
	if ($('#' + div).html() != "") {		//el div tiene codigo
		$('#' + div).hide();			//esconde el div
		$('#' + div).html("");		//borra el contenido del div
		$('#' + (padre == 0 ? 'i' + categoria : 'ia' + categoria + '_' + padre)).attr('src', 'images/collapsed.gif');
	} else {
		var param = "cat=" + categoria + "&padre=" + padre + "&usuario=" + $('#tusu_nom').val() + '&tpr='+($('#tp_perfil').length>0?$('#tp_perfil').val():0);
		param+="&operador="+$('#t_username').val();
		$.ajax({
			url: 'ayuda_hijos.php',
			cache: false,
			type: 'POST',
			data: param,
			success: function (data) {
				$('#' + (padre == 0 ? 'i' + categoria : 'ia' + categoria + '_' + padre)).attr('src', 'images/expanded.gif');
				$('#' + div).html(data);
				$('#' + div).show();
			}
		});
	}
}

function Info_Ventana(descripcion, persona){
	document.getElementById('t_'+persona).value = descripcion;
}
</script>
</head>
<body onLoad="document.getElementById('username').focus();">
<center>
<div id='general' style="width:1000px;"><?php echo ($_GET['op']==911?"<img src='images/cabeza911_chat.png' />":"<img src='images/cabezalocatel_chat.png' />");?><br />
<div id='centro' align="center"><?php include_once('login_chat.php')?></div></div>
<!--<div id="dmensaje" class="info message" style="display:none;">
 <h3>Información Importante</h3>
 <p>Al salir recuerda que es importante cerrar las conversaciones y despues tu sesión desde el botón, para que no se quede colgado tu usuario.</p>
</div>-->
<script>
 $(document).ready(function() {
     $(".login").show(1200);
	 //$(".login").fadeIn(1500);
   });
function Recuperar_Mensajes(id_conversacion, tmp){
var param = 'id_conversacion='+id_conversacion+'&id_institucion='+$('#id_institucion').val()+'&tp=0';
$.ajax({
	url: 'recupera_mensajes.php',
	cache:false,
	type: 'POST',
	data: param,
	//beforeSend: function(){$('#dmsg').html("<img src='chat/images/load_chat.gif' />");},
	success: function(data){
		if(data!=""){				
			$(".chatboxcontent").append(data);
			if($("#chatbox_"+tmp+" .chatboxcontent").length){
				$("#chatbox_"+tmp+" .chatboxcontent").scrollTop($("#chatbox_"+tmp+" .chatboxcontent")[0].scrollHeight);
			}
		}
	}
});
}

</script>
<!--<br /><br />-->
<div id="reloj" style="top:85px; left:75%; position:fixed; font-size:30px; color:#BF1E2E;" align="center"></div>
<!--<div id='ayuda' style="left:0px; position:absolute; display:none; top:120px; z-index:1; width:300px;" align="left"></div>-->
<div id='ayuda' style="left:0px; position:absolute; display:none; top:120px; z-index:1; min-width:30%; max-width:70%" align="left"></div>
<!--<div id='drespuestas' style="position:absolute; width:600px; text-align:justify; top:120px; font-size:12px; font-weight:bold; color:#133575; z-index:200; left:320px;"></div>-->
<div id='drespuestas' style="position:absolute; width:10px; text-align:justify; top:120px; font-size:12px; font-weight:bold; color:#133575; z-index:200; left:320px;"></div>
<div id="dcalidad" style="display:none"></div>
<input type="hidden" id="id_operador" name="id_operador" value="-1" />
<input type="hidden" id="int_status" />
<input type="hidden" id="int_cuadro" />
<input type="hidden" id="Interval_id" value="0" />
<input type="hidden" id="Interval_espera" value="0" />
<input type="hidden" id="Interval_Conversacion" value="0" />
<input type="hidden" id="t_username" />
<input type="hidden" id='id_conv_op' name='id_conv_op' />
<input type="hidden" id="status_automatico" />
<input type='hidden' id='int_chartbeat_titulo' />
<input type="hidden" id='val_reloj' name='val_reloj'  />
<!--<input id='t_time' type='hidden'  />-->
<input id='msg_enviados' type='hidden'  />

<div id="main_container"></div>
<audio id="chatAudio" src="sounds/New.mp3"></audio>
<audio id="chatAudio2" src="sounds/Emergente.mp3"></audio>
<audio id="EsperaAudioLista" src="sounds/espera.mp3"></audio>
<div id="contenido" align="center" style="display:none;"></div>
<div id="back" style="display:none"></div><br/><br/><br/><br/><br/>
<input type="hidden" id='id_institucion' name='id_institucion'  />
<input type="hidden" id='tp_seccion' name='tp_seccion'  />
<input type="hidden" id='id_original' name='id_original'  />
</center>
</body>
</html>