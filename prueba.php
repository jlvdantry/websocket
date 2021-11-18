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
  echo "onMessage sender=".print_r($sender['socket'],true)." message=".print_r($message,true)."\n";
  $user=getuserbysocket($sender['socket'],$server);
  echo "socket=".$user."\n";;
  $obj_msg=json_decode($message);
  switch($obj_msg->msg){
    case "IniciaSessionCliente" : IniciaSessionCliente($user,$server,$obj_msg);  break;
    case "IniciaSessionOperador" : IniciaSessionOperador($user,$server,$obj_msg);  break;
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
            $users[(int)$socket]->estatus=LISTAESPERA;   /* el operador se pone disponible  o en espera de un ciudadano */
            $msg = array('msg' => 'Se cerro conversacion');
            $envio=$server->send($socket,json_encode($msg));
            return true;
        }
    }
    echo __METHOD__." no encontro con quien terminar la conversacion"."\n";
    $msg = array('msg' => 'Se cerro conversacion');
    $envio=$server->send($socket,json_encode($msg));
    return $false;
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
    return false;
}

function BuscaClienteEspera($socket,$server,$obj_msg){
     echo __METHOD__." entro a buscar lista de espera\n";
     global $users;
     $found=null;
    foreach ($users as $user) {
        echo __METHOD__." user perfil=".print_r($user->perfil,true)." estatus ".print_r($user->estatus,true)."\n";
        if ($user->perfil == CIUDADANO && $user->estatus==LISTAESPERA) {
            echo __METHOD__." encontro cliente socket oper=".print_r($socket,true)." user=".print_r($user->socket,true)."\n";
            $msg = array('msg' => 'Encontro operador','nombre'=>$users[(int)$socket]->nombre,'id'=>$users[(int)$socket]->id);
            $server->send($user->socket,json_encode($msg));
            $msg = array('msg' => 'Encontro cliente','nombre'=>$users[(int)$user->socket]->nombre,'id'=>$users[(int)$user->socket]->id);
            $server->send($socket,json_encode($msg));
            $users[(int)$user->socket]->estatus=ENCONVERSACION;
            $users[(int)$socket]->estatus=ENCONVERSACION;
            return $user->socket;
        }
    }
    echo __METHOD__." no encontro lista de espera"."\n";
    return $found;
}

function IniciaSessionOperador($socket,$server,$obj_msg){
         global $users;
         $user = new User();
         $user->id = uniqid();
         $user->socket = $socket;
         $user->perfil = OPERADOR;
         $user->estatus = INICIOSESSION;
         $user->nombre = $obj_msg->nombre;
         $users[(int)$socket]=$user;
         echo __METHOD__." creo operador".print_r($users,true)."\n";
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
         echo __METHOD__." creo ciudadano".print_r($users,true)."\n";
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
            return $user->socket;
        }
    }
    echo __METHOD__." no encontro operador disponible"."\n";
    $msg = array('msg' => 'Espera');
    $server->send($socket,json_encode($msg));
    return $found;
}

function getuserbysocket($socket,$server){
  $found=null;
    foreach ($server->getClients() as $client) {
        echo __METHOD__." client=".print_r((int)$client['socket'],true)." y socket ".(int)$socket."\n";
        if ((int)$socket == (int)$client['socket']) {
            return $socket;
        }
    }
  echo "no encontro socket"."\n";
  return $found;
}


class User{
  var $id;
  var $socket;
  var $perfil; /* 0=ciudadano, 1=operador */
  var $estatus;  /* 0=lista de espersa, 1=En conversacion, 2=disponible, 3=en pausa */
  var $nombre;  /* nombre del ciudadano o del operador */
}



?>

