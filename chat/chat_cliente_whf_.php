<?php
//session.cookie_lifetime 60;
ini_set("session.cookie_lifetime", 60);
session_start();
echo '<meta charset="utf-8">';
echo '<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">';
echo "<title>Chat con Locatel</title>";
echo '<style type="text/css">';
echo "
* {
    font-family: inter;
}
.pleca {
    min-height: 2.5rem;
    background-color: #f8f8f8;
    display: flex;
    align-items: center;
    border-top: solid 0.31rem #f0f0f0;
}
.chatboxmessagecontent {
      font-size: 22px;  border-radius: 20px; background-color: #ededed; white-space: pre-wrap;
}

::-webkit-scrollbar {
  width: 5px;
}

/* Track */
::-webkit-scrollbar-track {
  background: #f1f1f1; 
}
 
/* Handle */
::-webkit-scrollbar-thumb {
  background: #888; 
}

/* Handle on hover */
::-webkit-scrollbar-thumb:hover {
  background: #555; 
}

.tiempo {
    text-align: right;
    color: #1a1a1a;
    opacity: 0.63;
    font-size: 13px;
}

#msg_final{
    overflow-y: scroll;
    overflow-x: hidden;
}

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

.btnconecta {
    background-color: #1a6058;
    border-radius: 6px;
    color:  #1a1a1a;
   font-size: 17px;
}

.circle-icon {
    background: #ffc0c0;
    width: 50px;
    height: 50px;
    border-radius: 50%;
    text-align: center;
    line-height: 100px;
    vertical-align: middle;
    padding: 10px;
}

.circle-icon-1x {
    background: #ffc0c0;
    width: 25px;
    height: 25px;
    border-radius: 50%;
    text-align: center;
    line-height: 100px;
    vertical-align: middle;
    padding: 5px;
}
.divchatboxinput {
    position: absolute !important;
    top: 88%;
    border-bottom-right-radius:10px;
}

.Path {
  position: absolute !important;
  top: 80%;
  left: 88%;
  width: 8px;
  height: 8px;
  border: 1px;
  background-color: white;
  border-radius: 50%;
  margin: 0px auto;
}

.Path:after {
    background-color: #00ae42;
    content: '';
    display: block;
    position: absolute;
    top: 1px;
    left: 1px;
    right: 1px;
    bottom: 1px;
    border-radius: 50%;
    /*z-index: -1; */
}

.Path-2x {
  position: absolute !important;
  top: 80%;
  left: 88%;
  width: 16px;
  height: 16px;
  border: 1px;
  background-color: white;
  border-radius: 50%;
  margin: 0px auto;
}

.Path-2x:after {
    background-color: #00ae42;
    content: '';
    display: block;
    position: absolute;
    top: 2px;
    left: 2px;
    right: 2px;
    bottom: 2px;
    border-radius: 50%;
    /*z-index: -1; */
}

textarea { border: none !important; resize: none !important; }
textarea:focus { outline: none !important;  resize: none !important;}


@media (max-width: 993px) {
   .Path-2x {
      left: 60%;
   }
   .Path {
      left: 95%;
   }
}
@media (max-width: 993px) {
    .radius {
        border-top-left-radius:10px ; border-top-right-radius:10px;
    }
    .pinlocatel {
         position: absolute !important;
         top: 5%; left:5%;
         display:none; 
    }
}

@media (min-width: 992px) {
    .radius {
        border-top-left-radius:10px ; border-bottom-left-radius:10px;
    }
    .pinlocatel {
         position: absolute !important;
         top: 55%; left:5%
    }
}

";
echo '</style>';
echo "<link type='text/css' rel='stylesheet' href='estilo/inter/inter.css' />\n";
echo "<link type='text/css' rel='stylesheet' href='https://pro.fontawesome.com/releases/v5.10.0/css/all.css' data-mutate-approach='sync' />\n";
echo "<link type='text/css' rel='stylesheet' href='../css/style.css' />\n";
echo '<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">';
echo '<audio id="chatAudio" src="sounds/New.mp3"></audio>';
echo '<audio id="chatAudio2" src="sounds/Emergente.mp3"></audio>';
echo '<header>
      <div class="container d-none">
         <div class="row justify-content-center m-2 p-1 ">
	      <a title="Regresar al inicio" href="cliente.php" class="col-lg-6 col-sm-12">
                     <img src="images/LogoChatLocatel.png" alt="Logotipos Gobierno Federal y Gobierno de la CDMX" class="img-fluid">
              </a>
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
            <div class="pleca" style="background-color: #f4f6f8 !important;">
               <div class="container mt-5" style="background-color: #f4f6f8 !important;">
                <div class="row justify-content-center">
		  <div class="col-md-11" id="cuadro_chat">
			   <div class="h-service jumbotron d-flex p-0 m-lg-5 flex-sm-column flex-lg-row flex-column bg-white" style=" border-radius:10px">
                              <div class="columna1 d-flex align-items-center justify-content-center p-2 h3 flex-wrap col-lg-6 mb-0 radius" style="background-color: #b5131b !important;" >
                                <div class="container">
                                  <div class="col-lg-6 mb-3 pinlocatel" >
                                        <img src="images/PinLocatel.png" class="float-xl-left img-fluid">
                                   </div>
                                   <div class="col-lg-12 col-sm-12 mb-2 h1" >
                                        <span class="text-white font-weight-bold">Chat</span>
                                   </div>
                                   <div class="col-lg-12 col-sm-12 mb-3" >
                                        <img src="images/LogoLOCATEL.png" alt="Logotipos Gobierno Federal y Gobierno de la CDMX" class="img-fluid">
                                   </div>
                                   <div class="col-lg-12 col-sm-12 h4" >
                                        <span class="text-white">Estamos para orientarte</span>
                                   </div>
                                   <div class="col-lg-12 col-sm-12 h6" >
                                        <span class="text-white">Horario de atención en chat: 8 a.m. a 8 p.m.</span>
                                   </div>
                                </div>
                              </div>
			      <!-- <div class="col-lg-6" > -->
				      <div id="div_chat" class=" columna2 col-lg-6 pr-0 pl-0" >
					       <div id="vtn_chat" class="col-lg-12 pr-0 pl-0"></div>
					       <h3 id="txt_msg"><br><br></h3>
					       <div id="form_chat">
                                                        <div class="h5 text-left  font-weight-bold col-12 mb-5" style=" font-size: 34px; "> Ingresa tus datos para contactar con un operador Locatel.</div>
							<div class="contact-form" align="center">
								<form role="form">
									  <div class="form-group col-lg-12 text-left">
									     <label class=" mb-1 h6" style="font-size: 22px;">Nombre</label>
                                                                             <input type="text" placeholder="Ingresa tu nombre" id="tuser" class="form-control text-left"  onkeypress="return Alfanumerico(event,this);" maxlength="30" onpaste="return false;">
                                                                          </div>
									  <div class="form-group col-lg-12 text-left">
									       <label class="mb-1 h6" style="font-size: 22px;">Correo electrónico</label>
                                                                               <input type="text" placeholder="Ingresa tu correo electr&oacute;nico" id="tmail" class="form-control text-left"  onkeypress="return Correo(event,this);" maxlength="50" onpaste="return false;">
                                                                          </div>
									  <br>
									  <div class="form-group col-lg-12 text-left">
                                                                               <button id="btnconecta" class="btn btnconecta text-white" type="button" onclick="Chat()">Iniciar chat</button>
                                                                          </div>
								</form>
							</div><br>
					       </div>
					       <div id="enlazandote" class="d-none col-12 mb-5">
                                                        <input type="hidden" id="id_espera" value="" />
                                                        <br>
                                                        <div class="col-lg-12 mb-5 text-left ml-2">
                                                              <i class="fas fa-sync fa-spin fa-5x" style="color: #b5131b !important;"></i>
                                                        </div>
                                                        <div class="h5 text-left  font-weight-bold col-12 mb-5" style=" font-size: 34px; ">Estamos enlazándote con un operador, en un momento te atenderemos.</div>
                                                        <br>
					       </div>
					       <div id="dmsg" class="text-center"></div>
				      </div> <!-- fin div_char -->
			      <!-- </div> -->
			   </div>
		  </div> <!-- fin cuadro_chat -->
                </div>
              </div>
             </div>
';
echo '<footer class="footerx d-none">
        <div class="container">
           <div class="row align-items-center flex-wrap">
		<div class="col-lg-6 col-sm-12">
		    <img class="img-fluid pr-4" src="images/Logofooter.png" alt="">
		</div>
		<div class="col-lg-6 col-sm-12">
		    <p class="label-footer text-right">Atenci&oacute;n Ciudadana</p>
		    <p class="label-footer text-right"><i class="fas fa-phone mr-1 fa-rotate-90" ></i>Locatel <a class="text-white" href="tel:+5556581111">55 5658 1111</a></p>
		</div>
           </div>
        </div>
        <div class="greca-footer"> </div> 
      </footer>
';
echo '<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>';
echo "<script src='js/chatcliente.js'type='text/javascript' language='javascript'></script>";
?>
