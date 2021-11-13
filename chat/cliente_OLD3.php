<?php
echo '<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">';
echo "<title>Chat con Locatel</title>";
echo '<style type="text/css">';
echo '
.footerx {
    height: auto !important;
    background: #04342c !important;
    width: 100% !important;
    position: relative !important;
    bottom: 0 !important;
    left: 0 !important;
    min-height: 3em !important;
    padding-top: 1em !important;
    width: 100%;
    color:white;
}
.greca-footer {
    background-image: url(images/greca.png);
    background-repeat: repeat-x;
    background-size: 50px;
    background-position-x: center;
    height: 25px;
}
}';
echo '</style>';
echo "<link type='text/css' rel='stylesheet' href='estilo/chat_locatel_20170406.css' />\n";
echo "<link type='text/css' rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css' />\n";
echo "<link type='text/css' rel='stylesheet' href='../css/style.css' />\n";
echo '<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">';
echo '<audio id="chatAudio" src="sounds/New.mp3"></audio>';
echo '<audio id="chatAudio2" src="sounds/Emergente.mp3"></audio>';
echo '<header>
      <div class="container">
         <div class="row justify-content-between m-1 p-1 align-items-end">
	      <a title="Regresar al inicio" href="cliente.php" class="col-6">
                     <img src="images/cdmx.png" alt="Logotipos Gobierno Federal y Gobierno de la CDMX" class="img-fluid">
              </a>
	<div class="col-6 text-right"><img src="images/locatel.png" alt="Logotipo de LOCATEL" class="img-fluid"></div>
         </div>
      </div>
      </header>';
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
               <div class="container mt-1">
                <div class="row justify-content-center">
		  <div class="col-md-9" id="cuadro_chat">
			   <div class="h-service jumbotron">
                              <div class="d-flex align-items-center bg-green justify-content-center p-2 h3 flex-wrap border rounded">
                                   <div class="col-lg-6 col-sm-12" >
                                        <i class="fa fa-comment m-1"></i>
                                        <span class="m-1 text-dark">CHAT</span>
                                   </div>
                                   <div class="col-lg-6 col-sm-12 text-right" >
                                        <span class="m-1 ">24 Horas/ 7 D&iacute;as</span>
                                   </div>
                              </div>
			      <div class="h-service-content wow fadeInUp animated" style="height: 398px; visibility: visible; animation-name: fadeInUp;" data-wow-animation-name="fadeInUp">
				      <div id="div_chat">
					       <div id="vtn_chat"></div>
					       <h3 id="txt_msg"><br><br></h3>
					       <div id="form_chat">
                                                        <div class="row m-4 text-center h5"> Ingresa tu nombre y tu correo para iniciar el chat con un operador de locatel, el cual te podr&aacute; asesorar.</div>
							<div class="contact-form" align="center">
								<form role="form">
									  <div class="form-group"><input type="text" placeholder="Ingresa tu nombre" id="tuser" class="form-control text-center" style="width:90%; height:29px; color:#000" onkeypress="return Alfanumerico(event,this);" maxlength="30" onpaste="return false;"></div>
									  <div class="form-group"><input type="text" placeholder="Ingresa tu correo electr&oacute;nico" id="tmail" class="form-control text-center" style="width:90%; height:29px; color:#000; " onkeypress="return Correo(event,this);" maxlength="50" onpaste="return false;"></div>
									  <br><button id="btnconecta" class="btn btn-info" type="button" onclick="Chat()">Iniciar chat</button>
								</form>
							</div><br>
					       </div>
					       <div id="dmsg" class="text-center"></div>
				      </div> <!-- fin div_char -->
			      </div>
			   </div>
		  </div> <!-- fin cuadro_chat -->
              </div>
            </div>
';
echo '<footer class="footerx">
        <div class="container">
           <div class="row align-items-center flex-wrap">
		<div class="col-lg-6 col-sm-12">
		    <img class="img-footer pi-footer pr-4" src="images/Logofooter.png" alt="">
		</div>
		<div class="col-lg-6 col-sm-12">
		    <p class="label-footer text-right">Atención Ciudadana</p>
		    <p class="label-footer text-right">Teléfono de LOCATEL</p>
		    <p class="label-footer text-right">55 5658 1111</p>
		</div>
           </div>
        </div>
        <div class="greca-footer"> </div> 
      </footer>
';
echo '<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>';
echo "<script src='js/chatcliente.js'type='text/javascript' language='javascript'></script>";
?>
