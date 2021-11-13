<?php
//session.cookie_lifetime 60;
ini_set("session.cookie_lifetime", 60);
session_start();
echo '<!doctype html>';
echo '<meta charset="utf-8">';
echo '<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">';
echo "<title>Chat con Locatel</title>";
echo '<style type="text/css">';
echo " 
* {
    font-family: inter;
}
 
html {
  height: 100%;
}
 body {
  min-height: 100vh;
  background-color: yellow;
}

.h-service {
     border-radius:12.2px !important;
     border-width: 2px !important;
}

#vtn_chat {
    position:relative;
}

.tienesdudas{
    border-bottom-right-radius: 15.24px;
    border-top-right-radius: 15.24px;
    border-top-left-radius: 15.24px;
    background: #1A6058;
    color: white;
    background-image: linear-gradient(to top, #000000 ,rgba(0, 0, 0, 0) );
}

.columna2 {
    background: #104C4217;
}
.pleca {
    min-height: 2.5rem;
    background-color: #f8f8f8;
    display: flex;
    align-items: center;
    border-top: solid 0.31rem #f0f0f0;
}
.chatboxmessagecontent {
      font-size: 22px;  border-radius: 6.93pxpx; background-color: #EDF2F7; white-space: pre-wrap;
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
    font-size: 17px;
    background: #8B652E;
    height: 42.22px;
    border-radius: 10.56px;
    width: 177.69px;
    border-style: unset;
}

.circle-icon {
    background: #E2FAC4;
    width: 50px;
    height: 50px;
    border-radius: 50%;
    text-align: center;
    line-height: 100px;
    vertical-align: middle;
    padding: 10px;
}

.fa-user:before {
    color: #6AA224;
}

.circle-icon-1x {
    background: #E2FAC4;
    width: 25px;
    height: 25px;
    border-radius: 50%;
    text-align: center;
    line-height: 100px;
    vertical-align: middle;
    padding: 5px;
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
  left: 65%;
  width: 16px;
  height: 16px;
  border: 1px;
  /*background-color: white; */
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
    .radius {
        border-top-left-radius:10px ; border-top-right-radius:10px;
    }

    .columna2 {
         border-bottom-left-radius:10px; border-bottom-right-radius:10px;
    }

    .pinlocatel {
         position: absolute !important;
         top: 5%; left:5%;
         display:none; 
   }
   .Path-2x {
      /*left: 30px; */
   }
   .Path {
      left: 95%;
   }
   .divchatboxinput {
/*	    position: absolute !important;
	    top: 83%; */
	    border-bottom-right-radius:12.2px;
	    border-bottom-left-radius:12.2px;
   }


}

@media (min-width: 992px) {
    .radius {
        border-top-left-radius:10px ; border-bottom-left-radius:10px;
    3}
    .pinlocatel {
         position: absolute !important;
         top: 55%; left:5%
    }
   .divchatboxinput {
            position: absolute !important;
            top: 93%;
            border-bottom-right-radius:12.2px;
   }

}

@media (max-width: 576px) {
    .logolocatel {
        display:none !important;
    }
    .ingresa {
         font-size: 24px !important; 
    }
    .chattexto::after {
         content: \" locatel\";
    }
    .fa-question-circle {
         display: contents !important;
    }
    .chatboxmessagecontent {
	      font-size: 15px;  border-radius: 6.93px; background-color: #EDF2F7; white-space: pre-wrap;
    }
    .nombredisponible {
          font-size: 17px !important; 
          font-weight: 700 !important;
    }
    #spin {
         margin-bottom: 20px;
    }
}

.tooltip-info .tooltip-inner {
        background-color: #5bc0de !important;
}
.tooltip-info  .arrow::before {
       border-top-color: #5bc0de !important;
       border-bottom-color: #5bc0de !important;
    }

.victoria_header {
    border-radius: 50%;
}

.tresonce{
    position: absolute;
    width: 30.52px;
    /* height: 19.84px; */
    left: 23%;
    top: 90%;
}

.horario {
    font-size: 11px !important;
    font-weight: 600;
}

.btn {
    font-weight: 600;
}


";
echo '</style>';
echo "<link type='text/css' rel='stylesheet' href='estilo/inter/inter.css' />\n";
echo "<link type='text/css' rel='stylesheet' href='https://pro.fontawesome.com/releases/v5.10.0/css/all.css' data-mutate-approach='sync' />\n";
echo "<link type='text/css' rel='stylesheet' href='../css/style.css' />\n";
echo '<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">';
##echo '<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>';
echo '<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>';
echo '<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>';
echo '<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>';
echo '<audio id="chatAudio" src="sounds/New.mp3"></audio>';
echo '<audio id="chatAudio2" src="sounds/Emergente.mp3"></audio>';
##echo '<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>';
##echo '<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js"></script>';
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
            <div class="pleca1" style="">
               <div class="container mt-1" style="">
                <div class="row justify-content-center">
		  <div class="col-md-11" id="cuadro_chat">
			   <div class="h-service d-flex p-0 pt-lg-0 mt-lg-5 flex-sm-column flex-lg-row flex-column bg-white flex-wrap h-100 mb-0" >

				      <div class="columna1 d-flex align-items-center justify-content-center p-lg-2 flex-wrap col-lg-6 mb-4 radius mb-sm-0 p-sm-0" style="background-color: white !important;" >
					<div class="container">
                                           <div class="mb-lg-1 border-bottom pb-lg-2 ">
						   <div class=" d-flex col-lg-12 " >
							<img src="images/PinLocatel.png" class="float-xl-left img-fluid">
						   </div>
						   <div class="col-lg-12 col-sm-12 h6 d-none text-center" style="color:  #104C42;" id="las24">
							<span style="font-weight:400">Atención las</span><span style="font-weight:700"> 24 horas</span>
						   </div>
                                           </div>

					   <div class="col-lg-12 col-sm-12  pt-4 d-flex pl-0 pr-0 align-items-start pt-lg-5"  id="div_tienesdudas">
					      <div class="col-6 p-0 text-lg-center mr-1">
							<img src="images/victoria_chat1.png" class="img-fluid victoria_header"></img>
					      </div>
					      <div class="col-6 text-left tienesdudas p-1 d-flex flex-wrap" >
						       <span style="font-weight: 700;font-style: normal;font-size: 16.75px;">¿Tienes dudas? </span>
						       <span style="font-weight: 400;font-style: normal;font-size: 16.75px;">Chatea con un operador</span>
					      </div>
					   </div>
					</div>
				      </div>

				      <div id="div_chat" class="columna2 col-lg-6 pr-0 pl-0 " >
					       <div id="vtn_chat" class="col-lg-12 pr-0 pl-0 "></div>
					       <h3 id="txt_msg"><br></h3>
					       <div id="form_chat" class="col-lg-12 mt-lg-5">
                                                        <div class="h5 text-left  font-weight-bold col-12 mb-4 ingresa d-none" style=" font-size: 34px; "> Ingresa tus datos para contactar con un operador Locatel.</div>
							<div class="contact-form" align="center">
								<form role="form">
									  <div class="form-group col-lg-12 text-left">
									     <label class=" mb-1 h6" style="font-size: 20.64px;color:  #104C42;font-weight: bold;">Nombre:</label>
                                                                             <input style="border: 2.81px solid #104C42" type="text" placeholder="Ingresa tu nombre" id="tuser" class="form-control text-left"  onkeypress="return Alfanumerico(event,this);" maxlength="30" onpaste="return false;">
                                                                          </div>
									  <div class="d-none form-group col-lg-12 text-left">
									       <label class="mb-1 h6" style="font-size: 22px;">Correo electrónico</label>
                                                                               <input type="text" placeholder="Ingresa tu correo electr&oacute;nico" id="tmail" class="form-control text-left"  value="peticiondelportalcdmx@cdmx.gob.mx" onkeypress="return Correo(event,this);" maxlength="50" onpaste="return false;">
                                                                          </div>
									  <br>
									  <div class="form-group col-lg-12 text-center mb-2">
                                                                               <button id="btnconecta" class="btnconecta text-white" type="button" onclick="Chat()">Iniciar chat</button>
                                                                          </div>
									   <div class="col-lg-12 col-sm-12 h6 " style="color:  #104C42;">
										<span style="font-weight:400">Atención</span><span style="font-weight:700"> 24 horas</span>
									   </div>
								</form>
							</div><br>
					       </div>
					       <div id="enlazandote" class="d-none col-12 mb-3">
                                                        <input type="hidden" id="id_espera" value="" />
                                                        <div id="spin" class="col-lg-12 mb-lg-5 mb-sm-1 text-center ml-2">
                                                              <i class="fas fa-sync fa-spin fa-5x" style="color: #b5131b !important;"></i>
                                                        </div>
                                                        <div class="h5 text-center  font-weight-bold col-12 mb-lg-5 ingresa" style=" font-size: 34px; ">Estamos enlazándote con un operador, en un momento te atenderemos.</div>
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
echo "<script src='js/chatcliente.js'type='text/javascript' language='javascript'></script>";
?>
