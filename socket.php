<?php
// this handler will forward each message to all clients (except the sender)
date_default_timezone_set('America/Mexico_City');
use vakata\websocket\Server;
//milog(dir".__dir__;
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/chat/bada.php';
        include_once('adodb/adodb.inc.php');
define ("CIUDADANO", 0);
define ("OPERADOR", 1);
define ("LISTAESPERA", 1);  /* para operador disponible para  ciudadano es lista de espera */
define ("ENCONVERSACION", 2);
define ("INICIOSESSION", 0);   /* el operador inicia session pero no esta disponible */
define ("OPE_ENPAUSA", 3);   /* se pone en pausa el operador estatus de bd para que funcione el back */
define ("OPE_LOGOUT", 0);   /* se pone en pausa el operador estatus de bd para que funcione el back */
$users=array();
//milog(dir=".__DIR__);
$server = new \vakata\websocket\Server('ws://127.0.0.1:15382');
$bd = new bada();
$co = $bd->Conectar();
milog(__METHOD__." bd=".print_r($bd,true));
$server->onMessage(function ($sender, $message, $server) {
  $user=getuserbysocket($sender['socket'],$server);
  milog(__METHOD__." encontro usuario socket=".$user->nombre);
  $obj_msg=json_decode($message);
  switch($obj_msg->msg){
    case "IniciaSessionCliente" : IniciaSessionCliente($user,$server,$obj_msg);  break;
    case "IniciaSessionOperador" : IniciaSessionOperador($user,$server,$obj_msg);  break;
    case "CierraSessionOperador" : CierraSessionOperador($user,$server,$obj_msg);  break;
    case "Operadordisponible" : BuscaClienteEspera($user,$server,$obj_msg);  break;
    case "OperadorReinicia" : PoneOperadorReinicia($user,$server,$obj_msg);  break;
    case "Escribiendo" : AquienEscribe($user,$server,$obj_msg);  break;
    case "Enviar mensaje" : EnviarMensaje($user,$server,$obj_msg);  break;
    case "Mensaje recibido" : MensajeRecibido($user,$server,$obj_msg);  break;
    case "Cerrar conversacion" : CerrarConversacion($user,$server,$obj_msg);  break;
    case "Cerrar conversacion ciudadano" : CerrarConversacionCiudadano($user,$server,$obj_msg);  break;
    default      : $msg = array('msg' => 'msg desconocido'); $server->send($user,json_encode($msg));           break;
  }
    
});

$server->onConnect(function ($server) {
     milog("se conecto");
});

$server->onDisconnect(function ($server) {
     global $users;
     milog("se desconecto nombre=".print_r($users[(int)$server['socket']]->nombre,true));
     unset($users[(int)$server['socket']]);
     enviaListaespera(); /* hay que ver si estaba en conversación o en espera para avisar a su contraparte */
});

$server->run();

function validaoperador($socket,$server){
     milog("operador inicio session ".print_r($socket,true));
     $msg = array('msg' => 'Espera');
     $server->send($socket,'operador valido',json_encode($msg));
}

function PoneOperadorReinicia($socket,$server,$obj_msg){
     global $users,$bd,$co;
     $users[(int)$socket]->estatus=INICIOSESSION;
     $msg = array('msg' => 'Puso Operador no disponible');
     $server->send($socket,json_encode($msg));
     $ok=$bd->OperadorIniciaSesion($users[(int)$socket],$co);
     milog(__METHOD__." reinicio el operador ".$users[(int)$socket]->estatus." nombre:".$users[(int)$socket]->nombre);
}

function MensajeRecibido($socket,$server,$obj_msg){
     milog(__METHOD__." entro");
     global $users,$bd,$co;
     $found=null;
    foreach ($users as $user) {
        if ($user->id==$obj_msg->id) {
            milog(__METHOD__." encontro a quien enviar mensaje=".print_r($user->id,true)." nombre=".$user->nombre);
            $msg = array('msg' => 'Mensaje recibido','date_recibido'=>$obj_msg->date_recibido);
            $server->send($user->socket,json_encode($msg));
            $ok=$bd->mensajeRecibido($user,$co);
            return $user->socket;
        }
    }
    milog(__METHOD__." no encontro a quien confirmar que fue recibido el mensaje");
    return $found;
}

function CerrarConversacion($socket,$server,$obj_msg){
     milog(__METHOD__." entro");
     global $users,$bd,$co;
     $found=null;
    foreach ($users as $user) {
        if ($user->id==$obj_msg->id) {
            milog(__METHOD__." encontro a quien cerrar la conversacion=".print_r($user->id,true)." nombre=".$user->nombre);
            $msg = array('msg' => 'Cierra conversacion');
            $envio=$server->send($user->socket,json_encode($msg));
            if ($envio==true) {
                milog(__METHOD__." finalizo conversacion del cliente=".print_r($user->id,true)." nombre=".$user->nombre);
                unset($users[(int)$user->socket]);
            }
            $users[(int)$socket]->estatus=INICIOSESSION;   /* el operador se pone en pausa */
            $msg = array('msg' => 'Se cerro conversacion');
            $envio=$server->send($socket,json_encode($msg));
            milog(__METHOD__." va a cerra conversacion en bd=".print_r($user->id,true));
            $ok=$bd->cierraConversacion($user,$co);
            return true;
        }
    }
    milog(__METHOD__." no encontro con quien terminar la conversacion");
    $msg = array('msg' => 'Se cerro conversacion');
    $envio=$server->send($socket,json_encode($msg));
    return false;
}

function CerrarConversacionCiudadano($socket,$server,$obj_msg){
     milog(__METHOD__." entro");
     global $users,$bd,$co;
     $found=null;
    foreach ($users as $user) {
        if ($user->id==$obj_msg->id) {
            milog(__METHOD__." encontro con quien terminar la conversación de=".$users[(int)$socket]->nombre." a=".$user->nombre);
            $msg = array('msg' => 'Cierra conversacion');
            $envio=$server->send($user->socket,json_encode($msg));
            if ($envio==true) {
                milog(__METHOD__." finalizo  la conversación de=".$users[(int)$socket]->nombre." a=".$user->nombre);
                $msg = array('msg' => 'Se cerro conversacion');
                $envio=$server->send($socket,json_encode($msg));
                unset($users[(int)$socket]);
            }
            $users[(int)$user->socket]->estatus=INICIOSESSION;   /* el operador se pone disponible  o en espera de un ciudadano */
            enviaListaespera();
            $ok=$bd->cierraConversacion($user,$co);
            return true;
        }
    }
    milog(__METHOD__." no encontro con quien terminar la conversacion de".$users[(int)$socket]->nombre);
    $msg = array('msg' => 'No se encontro con quien cerrar la conversacion');
    $envio=$server->send($socket,json_encode($msg));
    return false;
}



function EnviarMensaje($socket,$server,$obj_msg){
     milog(__METHOD__." entro");
     global $users,$bd,$co;
     $found=null;
    foreach ($users as $user) {
        if ($user->id==$obj_msg->id) {
            milog(__METHOD__." encontro a quien enviar mensaje a=".$user->nombre." de=".$users[(int)$socket]->nombre);
            $msg = array('msg' => 'Mensaje enviado','date'=>$obj_msg->date,'mensaje'=>$obj_msg->mensaje,'nombre'=>$users[(int)$socket]->nombre);
            $server->send($user->socket,json_encode($msg));
            $ok=$bd->enviaMensaje($users[(int)$socket],$users[(int)$user->socket],$co,$obj_msg->mensaje);
                 if ($ok!=false) {
                      milog(__METHOD__." id del mensaje".$ok);
                      $users[(int)$socket]->idMen=$ok;
                      $users[(int)$user->socket]->idMen=$ok;
                 }

            return $user->socket;
        }
    }
    milog(__METHOD__." no encontro a quien enviar el mensaje de=".$users[(int)$socket]->nombre." al id=".$obj_msg->id);
    return $found;
}

function AquienEscribe($socket,$server,$obj_msg){
     global $users;
     $found=null;
    foreach ($users as $user) {
        if ($user->id==$obj_msg->id) {
            $msg = array('msg' => 'Te estan escribiendo');
            $enviado=$server->send($user->socket,json_encode($msg));
            if ($enviado==false || $enviado=="") {
                milog(__METHOD__." error en el envio");
                $users[(int)$socket]->estatus=LISTAESPERA;
                unset($users[(int)$user->socket]);
                $msg = array('msg' => 'Se desconecto');
                $server->send($socket,json_encode($msg));
                return false;
            }
            return true;
        }
    }
    milog(__METHOD__." no encontro a quien le esta escribiendo");
                $msg = array('msg' => 'Se desconecto');
                $server->send($socket,json_encode($msg));
    return false;
}

function BuscaClienteEspera($socket,$server,$obj_msg){
     milog(__METHOD__." entro ");
     global $users,$bd,$co;
     $found=null;
    foreach ($users as $user) {
        if ($user->perfil == CIUDADANO && $user->estatus==LISTAESPERA) {
            milog(__METHOD__." encontro cliente en espera operador=".$users[(int)$socket]->nombre." ciudadano=".$users[(int)$user->socket]->nombre);
            $msg = array('msg' => 'Encontro operador','nombre'=>$users[(int)$socket]->nombre,'id'=>$users[(int)$socket]->id);
            $server->send($user->socket,json_encode($msg));
            $msg = array('msg' => 'Encontro cliente','nombre'=>$users[(int)$user->socket]->nombre,'id'=>$users[(int)$user->socket]->id);
            $server->send($socket,json_encode($msg));
            $users[(int)$user->socket]->estatus=ENCONVERSACION; /*ciudadano */
            $users[(int)$socket]->estatus=ENCONVERSACION;  /* operado */
            $users[(int)$user->socket]->idOpe=$users[(int)$socket]->idOpe; /*ciudadano */
            enviaListaespera();
            $ok=$bd->EnConversacion($users[(int)$socket],$users[(int)$user->socket],$co);
		 if ($ok!=false) {
                      milog(__METHOD__." id de la conversacion".$ok);
		      $users[(int)$socket]->idConv=$ok;
		      $users[(int)$user->socket]->idConv=$ok;
		 }

            return $user->socket;
        }
    }
    $ok=$bd->OperadorEnEspera($users[(int)$socket],$co);
    $users[(int)$socket]->estatus=LISTAESPERA;
    milog(__METHOD__." puso operador en espera".$users[(int)$socket]->nombre);
    return $found;
}

function IniciaSessionOperador($socket,$server,$obj_msg){
         global $users,$bd,$co;
         $ops = getopebyid($server,$obj_msg);
         if ($ops==false) {
		 $user = new User();
		 $user->id = uniqid();
		 $user->socket = $socket;
		 $user->perfil = OPERADOR;
		 $user->estatus = INICIOSESSION;
		 $user->nombre = $obj_msg->nombre;
		 $user->idOpe = $obj_msg->idOpe;
		 $users[(int)$socket]=$user;
                 $cuantos=getCuantosEsperando();
                 if ($cuantos>0) {
		    $msg = array('msg' => 'Lista de espera','tablero' => $cuantos);
		    $server->send($user->socket,json_encode($msg));
                 }
                 $ok=$bd->OperadorIniciaSesion($user,$co);
                 milog(__METHOD__." creo operador ".$user->nombre);
         } else {
            $msg = array('msg' => 'Estas vivo');
            $enviado=$server->send($ops->socket,json_encode($msg));
            milog(__METHOD__." encontro un operador y envio mensaje".print_r($ops,true));
            if ($enviado==false || $enviado=="") {   /* el socket esta idle */
                 milog(__METHOD__." elimino socket ".print_r((int)$ops->socket,true));
                 unset($users[(int)$ops->socket]);
            } else {
		    $msg = array('msg' => 'Otra session');
		    $enviado=$server->send($socket,json_encode($msg));
            }
         }
}

function CierraSessionOperador($socket,$server,$obj_msg){
         global $users, $bd, $co;
                 $msg = array('msg' => 'Cierra session');
                 $server->send($socket,json_encode($msg));
                 $ok=$bd->OperadorTerminaSesion($users[(int)$socket],$co);
                 milog(__METHOD__." cerro session operador ".$users[(int)$socket]->nombre);
                 unset($users[(int)$socket]);
}

function IniciaSessionCliente($socket,$server,$obj_msg){
         global $users;
         global $bd;
         global $co;
         $user = new User();
         $user->id = uniqid();
         $user->socket = $socket;
         $user->perfil = CIUDADANO;
         $user->estatus = LISTAESPERA;
         $user->nombre = $obj_msg->nombre;
         $user->correo = $obj_msg->correo;
         $user->inst = $obj_msg->inst;
         $users[(int)$socket]=$user;
         $ok=$bd->Creausuario($co,$user);
         milog(__METHOD__." creo ciudadano ".$user->nombre);
         if ($ok!=false) {
              $users[(int)$socket]->id=$ok;
              $user->id=$ok;
         }
         buscaoperadordisponible($socket,$server,$user);
}

function buscaoperadordisponible($socket,$server,$user_ciu){
     milog(__METHOD__." entro ");
     global $users, $bd, $co;
     $found=null;
    foreach ($users as $user) {
        if ($user->perfil == OPERADOR && $user->estatus==LISTAESPERA) {
            milog(__METHOD__." encontro operador=".$user->nombre." ciudadano=".$users[(int)$socket]->nombre);
            $msg = array('msg' => 'Encontro cliente','nombre'=>$users[(int)$socket]->nombre,'id'=>$users[(int)$socket]->id);
            $server->send($user->socket,json_encode($msg));
            $msg = array('msg' => 'Encontro operador','nombre'=>$users[(int)$user->socket]->nombre,'id'=>$users[(int)$user->socket]->id);
            $server->send($socket,json_encode($msg));
            $users[(int)$user->socket]->estatus=ENCONVERSACION; /*operador */
            $users[(int)$socket]->estatus=ENCONVERSACION;  /*ciudadano */
            $users[(int)$socket]->idOpe=$users[(int)$user->socket]->idOpe;  /*ciudadano */
            enviaListaespera();
            $ok=$bd->EnConversacion($users[(int)$user->socket],$users[(int)$socket],$co);
                 if ($ok!=false) {
                      milog(__METHOD__." id de la conversacion".$ok);
                      $users[(int)$socket]->idConv=$ok;
                      $users[(int)$user->socket]->idConv=$ok;
                 }
            return $user->socket;
        }
    }
    milog(__METHOD__." no encontro operador disponible ".$users[(int)$socket]->nombre);
    $msg = array('msg' => 'Espera');
    $server->send($socket,json_encode($msg));
    enviaListaespera();
    $ok=$bd->CreaListaEspera($co,$user_ciu);
         if ($ok!=false) {
              $users[(int)$socket]->id_espera=$ok;
         }
    return $found;
}

function getCuantosEsperando(){
    global $users;
    $cuantos=0;
    $tablero = new Tablero();
    foreach ($users as $user) {
        if ($user->perfil == CIUDADANO && $user->estatus==LISTAESPERA) {
            $tablero->ciu_enespera=$tablero->ciu_enespera+1;
        }
        if ($user->perfil == OPERADOR && $user->estatus==INICIOSESSION) {
            $tablero->ope_enpausa=$tablero->ope_enpausa+1;
        }
        if ($user->perfil == OPERADOR && $user->estatus==LISTAESPERA) {
            $tablero->ope_enespera=$tablero->ope_enespera+1;
        }
        if ($user->perfil == OPERADOR && $user->estatus==ENCONVERSACION) {
            $tablero->ope_enconversacion=$tablero->ope_enconversacion+1;
        }
    }
    return $tablero;
}

function enviaListaespera(){
    global $users;
    global $server;
    $cuantos=getCuantosEsperando();
	    foreach ($users as $user) {
		if ($user->perfil == OPERADOR) {
		    milog(__METHOD__." va a enviar lista a=".$user->nombre);
		    $msg = array('msg' => 'Lista de espera','tablero' => $cuantos);
		    $server->send($user->socket,json_encode($msg));
		}
	    }

}

function getuserbysocket($socket,$server){
    global $users;
  $found=null;
    foreach ($server->getClients() as $client) {
        if ((int)$socket == (int)$client['socket']) {
            return $socket;
        }
    }
  milog(__METHOD__." no encontro socket=".users[(int)$socket]->nombre);
  return $found;
}

function getopebyid($server,$objmsg){
    $found=false;
    global $users;
    foreach ($users as $user) {
        if ($user->perfil==OPERADOR && $objmsg->idOpe == $user->idOpe) {
            return $user;
        }
    }
  milog(__METHOD__." no encontro operador por id=". $objmsg->idOpe);
  return $found;
}

function milog($msg) {
   $fecha=date('Ymd');
   $hora=date('H:i:s');
   error_log($hora." ".$msg."\n", 3, "chat/logs/socket_".$fecha.".log");

}



class User{
  var $id;  
  var $socket;
  var $perfil; /* 0=ciudadano, 1=operador */
  var $estatus;  /* 0=lista de espersa, 1=En conversacion, 2=disponible, 3=en pausa */
  var $nombre;  /* nombre del ciudadano o del operador */
  var $idOpe;  
  var $correo;  
  var $inst;    /*institucion */
  var $id_espera;    /*id de la lista de espera */
  var $idConv; /* id de la conversacion */
  var $idMen; /* id delmensaje */
}

class Tablero{
  var $ciu_enespera=0;
  var $ope_enespera=0;  /* o disponible */
  var $ope_enpausa=0; /* operador en pausa */
  var $ope_enconversacion=0; /* operador en pausa */
}



?>

