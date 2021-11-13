<?php
echo "<title>Chat con Locatel</title>";
echo "<link type='text/css' rel='stylesheet' href='estilo/chat_locatel_20170406.css' />\n";
echo "<link type='text/css' rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css' />\n";
echo "<link type='text/css' rel='stylesheet' href='../css/style.css' />\n";
echo '<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">';
echo '<audio id="chatAudio" src="sounds/New.mp3"></audio>';
echo '<audio id="chatAudio2" src="sounds/Emergente.mp3"></audio>';
echo ' <div id="layout_chat"></div>
<input id="conversacion" type="hidden" value="0">
<input id="id_inst" type="hidden" value="1">
<input id="slider_chat" type="hidden" value="0">
<input id="t_username" type="hidden" name="t_username">
<input id="int_conv" type="hidden" name="int_conv">
<input id="int_chartbeat" type="hidden" name="int_chartbeat">
<input id="int_chartbeat_titulo" type="hidden" name="int_chartbeat_titulo">
<input id="t_time" type="hidden">
<input id="msg_enviados" type="hidden">
<input id="int_slider" type="hidden">
<!--
<div class="row justify-content-center mt-5">
    <div class="col-md-10">
        <div class="card">
            <div class="card-body">
-->
               <div class="container mt-5">
                <div class="row justify-content-center">
		  <div class="col-md-9" id="cuadro_chat">
			   <div class="h-service"><!--class="h-service"-->
                              <!--
                              <div class="icon-wrap ico-bg round-fifty wow fadeInDown animated" style="background-image: url(&quot;img/icon_chat.PNG&quot;); max-width: 100%; vertical-align: middle; background-repeat: no-repeat; visibility: visible; animation-name: fadeInDown;" data-wow-animation-name="fadeInDown"></div> -->
                              <div class="d-flex align-items-center bg-green justify-content-center p-2 h3"><i class="fa fa-comment m-1"></i><span class="m-1 text-dark">CHAT</span><span class="m-1">24 Horas/ 7 Días</span></div>
			      <div class="h-service-content wow fadeInUp animated" style="height: 398px; visibility: visible; animation-name: fadeInUp;" data-wow-animation-name="fadeInUp">
				      <div id="div_chat">
					       <div id="vtn_chat"></div>
					       <h3 id="txt_msg"><br><br></h3>
					       <div id="form_chat"><br><br>
                                                        <div class="m-4 text-center h5"> Ingresa tu nombre y tu correo para iniciar el chat con un operador de locatel, el cual te podrá asesorar.</div>
							<div class="contact-form" align="center">
								<form role="form">
									  <div class="form-group"><input type="text" placeholder="Ingresa tu nombre" id="tuser" class="form-control" style="width:90%; height:29px; color:#000" onkeypress="return Alfanumerico(event,this);" maxlength="30" onpaste="return false;"></div>
									  <div class="form-group"><input type="text" placeholder="Ingresa tu email" id="tmail" class="form-control" style="width:90%; height:29px; color:#000; text-transform:lowercase;" onkeypress="return Correo(event,this);" maxlength="50" onpaste="return false;"></div>
									  <br><button id="btnconecta" class="btn btn-info" type="button" onclick="Chat()">Accesar</button>
								</form>
							</div><br>
					       </div>
					       <div id="dmsg"></div>
				      </div> <!-- fin div_char -->
			      </div>
			   </div>
		  </div> <!-- fin cuadro_chat -->
              </div>
            </div>
<!--
            </div>
        </div>
    </div>
</div>
-->
';
echo '<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>';
echo "<script src='js/chatcliente.js'type='text/javascript' language='javascript'></script>";
?>
