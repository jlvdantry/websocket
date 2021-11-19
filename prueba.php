<?php
// this handler will forward each message to all clients (except the sender)
use vakata\websocket\Server;

require_once __DIR__ . '/vendor/autoload.php';
define ("CIUDADANO", 0);
define ("OPERADOR", 1);
define ("LISTAESPERA", 1);  /* para operador disponible para  ciudadano es lista de espera */
define ("ENCONVERSACION", 2);
define ("INICIOSESSION", 0);   /* el operador inicia session pero no esta disponible */
$users=array();
//echo "dir=".__DIR__."\n";
$server = new \vakata\websocket\Server('ws://127.0.0.1:15382');
$server->onMessage(function ($sender, $message, $server) {
  echo __METHOD__."onMessage sender=".print_r($sender['socket'],true)." message=".print_r($message,true)."\n";
  $user=getuserbysocket($sender['socket'],$server);
  echo __METHOD__." encontro usuario socket=".$user."\n";;
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
     echo "se conecto\n";
});

$server->onDisconnect(function ($server) {
     global $users;
     echo "se desconecto".print_r($server['socket'],true)."\n";
     unset($users[(int)$server['socket']]);
     enviaListaespera();
});

$server->run();

function validaoperador($socket,$server){
     echo "operador inicio session ".print_r($socket,true)."\n";
     $msg = array('msg' => 'Espera');
     $server->send($socket,'operador valido',json_encode($msg));
}

function PoneOperadorReinicia($socket,$server,$obj_msg){
     global $users;
     $users[(int)$socket]->estatus=INICIOSESSION;
     $msg = array('msg' => 'Puso Operador no disponible');
     $server->send($socket,json_encode($msg));
     echo "--".__METHOD__." puso estatus del operador como".$users[(int)$socket]->estatus."\n";
}

function MensajeRecibido($socket,$server,$obj_msg){
     echo __METHOD__." entro \n";
     global $users;
     $found=null;
    foreach ($users as $user) {
        echo __METHOD__." user perfil=".print_r($user->perfil,true)." estatus ".print_r($user->estatus,true)."\n";
        if ($user->id==$obj_msg->id) {
            echo __METHOD__." encontro a quien enviar mensaje=".print_r($user->id,true)."\n";
            $msg = array('msg' => 'Mensaje recibido','date_recibido'=>$obj_msg->date_recibido);
            $server->send($user->socket,json_encode($msg));
            return $user->socket;
        }
    }
    echo __METHOD__." no encontro a quien confirmar que fue recibido el mensaje"."\n";
    return $found;
}

function CerrarConversacion($socket,$server,$obj_msg){
     echo __METHOD__." entro \n";
     global $users;
     $found=null;
    foreach ($users as $user) {
        echo __METHOD__." user perfil=".print_r($user->perfil,true)." estatus ".print_r($user->estatus,true)."\n";
        if ($user->id==$obj_msg->id) {
            echo __METHOD__." encontro a quien enviar mensaje=".print_r($user->id,true)."\n";
            $msg = array('msg' => 'Cierra conversacion');
            $envio=$server->send($user->socket,json_encode($msg));
            if ($envio==true) {
                echo __METHOD__." finalizo conversacion del cliente=".print_r($user->id,true)."\n";
                unset($users[(int)$user->socket]);
            }
            $users[(int)$socket]->estatus=INICIOSESSION;   /* el operador se pone en pausa */
            $msg = array('msg' => 'Se cerro conversacion');
            $envio=$server->send($socket,json_encode($msg));
            return true;
        }
    }
    echo __METHOD__." no encontro con quien terminar la conversacion"."\n";
    $msg = array('msg' => 'Se cerro conversacion');
    $envio=$server->send($socket,json_encode($msg));
    return false;
}

function CerrarConversacionCiudadano($socket,$server,$obj_msg){
     echo __METHOD__." entro \n";
     global $users;
     $found=null;
    foreach ($users as $user) {
        echo __METHOD__." user perfil=".print_r($user->perfil,true)." estatus ".print_r($user->estatus,true)."\n";
        if ($user->id==$obj_msg->id) {
            echo __METHOD__." encontro con quien terminar la conversación=".print_r($user->id,true)."\n";
            $msg = array('msg' => 'Cierra conversacion');
            $envio=$server->send($user->socket,json_encode($msg));
            if ($envio==true) {
                echo __METHOD__." finalizo conversacion del cliente=".print_r($user->id,true)."\n";
                $msg = array('msg' => 'Se cerro conversacion');
                $envio=$server->send($socket,json_encode($msg));
                unset($users[(int)$socket]);
            }
            $users[(int)$user->socket]->estatus=LISTAESPERA;   /* el operador se pone disponible  o en espera de un ciudadano */
            enviaListaespera();
            return true;
        }
    }
    echo __METHOD__." no encontro con quien terminar la conversacion"."\n";
    $msg = array('msg' => 'No se encontro con quien cerrar la conversacion');
    $envio=$server->send($socket,json_encode($msg));
    return false;
}



function EnviarMensaje($socket,$server,$obj_msg){
     echo __METHOD__." entro \n";
     global $users;
     $found=null;
    foreach ($users as $user) {
        echo __METHOD__." user perfil=".print_r($user->perfil,true)." estatus ".print_r($user->estatus,true)."\n";
        if ($user->id==$obj_msg->id) {
            echo __METHOD__." encontro a quien enviar mensaje=".print_r($user->id,true)."\n";
            $msg = array('msg' => 'Mensaje enviado','date'=>$obj_msg->date,'mensaje'=>$obj_msg->mensaje,'nombre'=>$users[(int)$socket]->nombre);
            $server->send($user->socket,json_encode($msg));
            //$server->send($socket,json_encode($msg));
            return $user->socket;
        }
    }
    echo __METHOD__." no encontro a quien enviar el mensaje"."\n";
    return $found;
}

function AquienEscribe($socket,$server,$obj_msg){
     echo __METHOD__." entro \n";
     global $users;
     $found=null;
    foreach ($users as $user) {
        echo __METHOD__." user perfil=".print_r($user->perfil,true)." estatus ".print_r($user->estatus,true)."\n";
        if ($user->id==$obj_msg->id) {
            $msg = array('msg' => 'Te estan escribiendo');
            $enviado=$server->send($user->socket,json_encode($msg));
            echo __METHOD__." encontro a quien escribile=".print_r($user->id,true)." resuldato del envio $enviado \n";
            if ($enviado==false || $enviado=="") {
                echo __METHOD__." error en el envio \n";
                $users[(int)$socket]->estatus=LISTAESPERA;
                unset($users[(int)$user->socket]);
                $msg = array('msg' => 'Se desconecto');
                $server->send($socket,json_encode($msg));
                return false;
            }
            return true;
        }
    }
    echo __METHOD__." no encontro a quien le esta escribiendo"."\n";
                $msg = array('msg' => 'Se desconecto');
                $server->send($socket,json_encode($msg));
    return false;
}

function BuscaClienteEspera($socket,$server,$obj_msg){
     echo __METHOD__." entro a buscar lista de espera\n";
     global $users;
     $found=null;
    foreach ($users as $user) {
        echo __METHOD__." user perfil=".print_r(json_encode($user),true)."\n";
        if ($user->perfil == CIUDADANO && $user->estatus==LISTAESPERA) {
            echo __METHOD__." encontro cliente socket oper=".print_r($socket,true)." user=".print_r($user->socket,true)."\n";
            $msg = array('msg' => 'Encontro operador','nombre'=>$users[(int)$socket]->nombre,'id'=>$users[(int)$socket]->id);
            $server->send($user->socket,json_encode($msg));
            $msg = array('msg' => 'Encontro cliente','nombre'=>$users[(int)$user->socket]->nombre,'id'=>$users[(int)$user->socket]->id);
            $server->send($socket,json_encode($msg));
            $users[(int)$user->socket]->estatus=ENCONVERSACION;
            $users[(int)$socket]->estatus=ENCONVERSACION;
            echo "--".__METHOD__." puso estatus del operador como".$users[(int)$socket]->estatus."\n";
             enviaListaespera();
            return $user->socket;
        }
    }
    $users[(int)$socket]->estatus=LISTAESPERA;
    echo "--".__METHOD__." puso estatus del operador como".$users[(int)$socket]->estatus."\n";
    return $found;
}

function IniciaSessionOperador($socket,$server,$obj_msg){
         global $users;
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
		    $msg = array('msg' => 'Lista de espera','cuantos' => $cuantos);
		    $server->send($user->socket,json_encode($msg));
                 }
                 echo __METHOD__." creo operador ".json_encode($user)."\n";
         } else {
            $msg = array('msg' => 'Estas vivo');
            $enviado=$server->send($ops->socket,json_encode($msg));
            echo __METHOD__." encontro un operador y envio mensaje".print_r($ops,true)."\n";
            if ($enviado==false || $enviado=="") {   /* el socket esta idle */
                 echo __METHOD__." elimino socket ".print_r((int)$ops->socket,true)."\n";
                 unset($users[(int)$ops->socket]);
            } else {
		    $msg = array('msg' => 'Otra session');
		    $enviado=$server->send($socket,json_encode($msg));
            }
         }
}

function CierraSessionOperador($socket,$server,$obj_msg){
         global $users;
                 $msg = array('msg' => 'Cierra session');
                 $server->send($socket,json_encode($msg));
                 unset($users[(int)$socket]);
                 echo __METHOD__." cerro session de".print_r((int)$socket,true)."\n";
}

function IniciaSessionCliente($socket,$server,$obj_msg){
         global $users;
         $user = new User();
         $user->id = uniqid();
         $user->socket = $socket;
         $user->perfil = CIUDADANO;
         $user->estatus = LISTAESPERA;
         $user->nombre = $obj_msg->nombre;
         $users[(int)$socket]=$user;
         echo __METHOD__." creo ciudadano".print_r(json_encode($user,true),true)."\n";
         buscaoperadordisponible($socket,$server);
}

function buscaoperadordisponible($socket,$server){
     echo __METHOD__." entro a buscar operador\n";
     global $users;
     $found=null;
    foreach ($users as $user) {
        echo __METHOD__."user perfil=".print_r($user->perfil,true)." estauts ".print_r($user->estatus,true)."\n";
        if ($user->perfil == OPERADOR && $user->estatus==LISTAESPERA) {
            $msg = array('msg' => 'Encontro cliente','nombre'=>$users[(int)$socket]->nombre,'id'=>$users[(int)$socket]->id);
            $server->send($user->socket,json_encode($msg));
            $msg = array('msg' => 'Encontro operador','nombre'=>$users[(int)$user->socket]->nombre,'id'=>$users[(int)$user->socket]->id);
            $server->send($socket,json_encode($msg));
            $users[(int)$user->socket]->estatus=ENCONVERSACION;
            $users[(int)$socket]->estatus=ENCONVERSACION;
            enviaListaespera();
            return $user->socket;
        }
    }
    echo __METHOD__." no encontro operador disponible"."\n";
    $msg = array('msg' => 'Espera');
    $server->send($socket,json_encode($msg));
    enviaListaespera();
    return $found;
}

function getCuantosEsperando(){
    global $users;
    $cuantos=0;
    foreach ($users as $user) {
        if ($user->perfil == CIUDADANO && $user->estatus==LISTAESPERA) {
            $cuantos=$cuantos+1;
        }
    }
    return $cuantos;
}

function enviaListaespera(){
    global $users;
    global $server;
    $cuantos=getCuantosEsperando();
    echo __METHOD__." ciudadanos en espera=".$cuantos."\n";
    foreach ($users as $user) {
        if ($user->perfil == OPERADOR) {
            echo __METHOD__." va a enviar lista=".$user->socket."\n";
            $msg = array('msg' => 'Lista de espera','cuantos' => $cuantos);
            $server->send($user->socket,json_encode($msg));
        }
    }
}

function getuserbysocket($socket,$server){
  $found=null;
    foreach ($server->getClients() as $client) {
        echo __METHOD__." client=".print_r((int)$client['socket'],true)." y socket ".(int)$socket."\n";
        if ((int)$socket == (int)$client['socket']) {
            return $socket;
        }
    }
  echo __METHOD__."no encontro socket"."\n";
  return $found;
}

function getopebyid($server,$objmsg){
    $found=false;
    global $users;
    foreach ($users as $user) {
        echo __METHOD__." perfil=".print_r(json_encode($user),true)."\n";
        if ($user->perfil==OPERADOR && $objmsg->idOpe == $user->idOpe) {
            return $user;
        }
    }
  echo __METHOD__."no encontro socket"."\n";
  return $found;
}



class User{
  var $id;  
  var $socket;
  var $perfil; /* 0=ciudadano, 1=operador */
  var $estatus;  /* 0=lista de espersa, 1=En conversacion, 2=disponible, 3=en pausa */
  var $nombre;  /* nombre del ciudadano o del operador */
  var $idOpe;  
}



?>

