<?php
   use vakata\websocket\Server;
   require_once 'vendor/autoload.php';
   include('mycurl.php');
   $nombre=$argv[1];
   sleep(2);
   $cookie=dirname(__FILE__)."/cookies/".$nombre;
   $log=dirname(__FILE__)."/logs/".$nombre.".log";
   $url="https://chat_laravel.soluint.com/";
   echo "antes new\n";
   $client = new \vakata\websocket\Client('ws://127.0.0.1:15382');
   $client->run();
   echo print_r($client,true);
try {
   echo $nombre." ".date('Y-m-d H:i:s.') . gettimeofday()['usec']." nombre=".$nombre." log=".$log."\n";
   $fields = array('nombre' => $nombre,'correo'=>'pruebamasiva@hotmail.com','nombre2'=>$nombre,'inst'=>'1');
   $x = new mycurl($url.'cliente_whf.php');
   $x->setCookiFileLocation($cookie);
   $x->createCurl($url.'cliente_whf.php');
   echo $nombre." ".date('Y-m-d H:i:s.') . gettimeofday()['usec']."estatus cliente ".(string)$x->getHttpStatus()."\n" ;
   $x->setPost($fields);
   $x->createCurl($url.'conecta.php');
   echo $nombre." ".date('Y-m-d H:i:s.') . gettimeofday()['usec']." estatus conecta ".(string)$x->getHttpStatus()."\n" ;
   if ((string)$x->getHttpStatus()=="200") {
          conectado($x,$nombre,$url);
   } else {
       echo $nombre." ".date('Y-m-d H:i:s.') . gettimeofday()['usec']." erro ".(string)$x->getHttpStatus()."=".$x->__tostring()."\n" ;
   }
} 
catch (Exception $e){
	    echo $nombre." ".date('Y-m-d H:i:s.') . gettimeofday()['usec']." ".$e->getMessage() . "<br/>";
	      while($e = $e->getPrevious()) {
		            echo $nombre." ".date('Y-m-d H:i:s.') . gettimeofday()['usec'].' Previous exception: '.$e->getMessage() . "<br/>";
	       }
}

function conectado($x,$nombre,$url) {
           $cliente = new \vakata\websocket\Client('ws://127.0.0.1:15382');
           //echo print_r($id_espera->getAttribute('value'),true);

	   if (is_null($id_espera_obj)) { 
                 echo $nombre." ".date('Y-m-d H:i:s.') . gettimeofday()['usec']." nulo espera\n".print_r($x,true) ;
	   } 
	   else { 
                    $id_espera=$doc->getElementById('id_espera')->getAttribute('value');
                    $fields = array('id_espera' => $id_espera,'correo'=>$correo,'nombre2'=>$nombre,'inst'=>'1','nombre'=>$nombre);
                    $x->setPost($fields);
                    for($i = 0; $i < 100; ++$i) {
                       sleep(3);
                       $x->createCurl($url.'lista_espera.php');
                       echo $nombre." ".date('Y-m-d H:i:s.') . gettimeofday()['usec']." estatus lista_espera ".(string)$x->getHttpStatus()."\n" ;
                       if ((string)$x->getHttpStatus()=="200") {
			   $doc = new DOMDocument();
			   $doc->validateOnParse = true;
			   $doc->loadHTML($x->__tostring());
			   $id_operador_obj=$doc->getElementById('id_operador');
			   if (is_null($id_operador_obj)) {
                               echo $nombre." ".date('Y-m-d H:i:s.') . gettimeofday()['usec']." no hay operador ".$i."\n" ;
			   }
			   else {
                               echo $nombre." ".date('Y-m-d H:i:s.') . gettimeofday()['usec']." si hay operador ".$i."\n" ;
			       $id_operador=$id_operador_obj->getAttribute('value');
			       $id_conversacion=$doc->getElementById('id_conversacion')->getAttribute('value');
			       $login_operador=$doc->getElementById('login_operador')->getAttribute('value');
			       conversacion($x,$nombre,$id_operador,$id_conversacion,$login_operador,$correo,$url);
			       break;
                           }
                       }
                    }
           }
}
function conversacion($x,$nombre,$id_operador,$id_conversacion,$login_operador,$correo,$url) {
	            $nummen=0;
	            for($i = 0; $i < 92; ++$i) {  /* envia mensajes */
			    $fields = array('conversacion'=>$id_conversacion
				     ,'correo'=>$correo,'nombre'=>$nombre,'us'=>$nombre);
                            $x->setPost($fields);
                            sleep(3);
                            $x->createCurl($url.'status_conversacion.php');
                            echo $nombre." ".date('Y-m-d H:i:s.') . gettimeofday()['usec']." estatus conversacion ".(string)$x->getHttpStatus()."\n" ;
                            if ((string)$x->getHttpStatus()=="200") {
				      Verificar_Mensajes_Nuevos($x,$nombre,$id_operador,$id_conversacion,$login_operador,$correo,$url);
				      //Verificar_Mensajes_Recibidos_Usuario($x);
			    }
			    if ($i==10 || $i==20 || $i==30) {
				$nummen=$nummen+1;
                                enviamensajes($x,$nombre,$id_operador,$id_conversacion,$login_operador,$nummen,$url);
			    }

                    }

}

function Verificar_Mensajes_Nuevos($x,$nombre,$id_operador,$id_conversacion,$login_operador,$correo,$url) {
			    $fields = array('action'=>'chatheartbeat'
				     ,'un'=>$nombre,'id_conv'=>$id_conversacion);
                            $x->setPost($fields);
                            $x->createCurl($url.'chat.php');
                            echo $nombre." ".date('Y-m-d H:i:s.') . gettimeofday()['usec']." recibio mensaje ".(string)$x->getHttpStatus()."\n" ;
}

function Verificar_Mensajes_Recibidos_Usuario($x){
			    $fields = array('action'=>'chatheartbeat_status'
				     ,'msg'=>'');
                            $x->setPost($fields);
                            $x->createCurl($url.'chat.php');
}

function enviamensajes($x,$nombre,$id_operador,$id_conversacion,$login_operador,$i,$url) {
                            $fields = array('action' => 'sendchat','to'=>$login_operador,'message'=>'message '.$i,'conversacion'=>$id_conversacion
                                     ,'conversacion_op'=>'','operador'=>'','from_de'=>$nombre);
                            $x->setPost($fields);
                            sleep(30);
                            $x->createCurl($url.'chat.php');
                            echo $nombre." ".date('Y-m-d H:i:s.') . gettimeofday()['usec']." envio mensaje ".$i." ".(string)$x->getHttpStatus()."\n" ;
}
?>
