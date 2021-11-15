<?php
// this handler will forward each message to all clients (except the sender)
use vakata\websocket\Server;

require_once __DIR__ . '/vendor/autoload.php';
//echo "dir=".__DIR__."\n";
$server = new \vakata\websocket\Server('ws://127.0.0.1:15382');
$server->onMessage(function ($sender, $message, $server) {
  echo "onMessage sender=".print_r($sender['socket'],true)." message=".print_r($message,true)."\n";
  $user=getuserbysocket($sender['socket'],$server);
  echo "socket=".$user."\n";;
  $obj_msg=json_decode($message);
  switch($obj_msg->msg){
    case "IniciaSessionCliente" : buscaoperador($user,$server);  break;
    case "IniciaSessionOperador" : $server->send($user,"hola humano");  break;
/*
    case "hi"    : send($user->socket,"zup human");                         break;
    case "name"  : send($user->socket,"my name is Multivac, silly I know"); break;
    case "age"   : send($user->socket,"I am older than time itself");       break;
    case "date"  : send($user->socket,"today is ".date("Y.m.d"));           break;
    case "time"  : send($user->socket,"server time is ".date("H:i:s"));     break;
    case "thanks": send($user->socket,"you're welcome");                    break;
    case "bye"   : send($user->socket,"bye");                               break;
*/
    default      : $server->send($user," not understood");           break;
  }
    
});

$server->run();

$server->onConnect(function ($server) {
     echo "se conecto\n";
});

function buscaoperador($socket,$server){
     echo "entro a buscar operador\n";
     $server->send($socket,'Espera');
}

function getuserbysocket($socket,$server){
  $found=null;
    foreach ($server->getClients() as $client) {
        echo "client=".print_r((int)$client['socket'],true)." y socket ".(int)$socket."\n";
        if ((int)$socket == (int)$client['socket']) {
            return $socket;
        }
    }
  echo "no encontro socket"."\n";
  return $found;
}


?>

