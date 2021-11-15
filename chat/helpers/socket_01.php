<?php
/*
 *  Example of HOWTO: PHP TCP Server/Client with SSL Encryption using Streams
 *  Server side Script
 * 
 *  Website : http://blog.leenix.co.uk/2011/05/howto-php-tcp-serverclient-with-ssl.html
 */

$ip="127.0.0.1";               //Set the TCP IP Address to listen on
$port="15382";                  //Set the TCP Port to listen on
$pem_passphrase = "jlvdantry";   //Set a password here
$pem_file = "/var/www/html/chat_socket/chat/helpers/chatws.pem";    //Set a path/filename for the PEM SSL Certificate which will be created.
error_reporting(E_ALL);
set_time_limit(0);
ob_implicit_flush();


//The following array of data is needed to generate the SSL Cert
$pem_dn = array(
 "countryName" => "MX",                 //Set your country name
 "stateOrProvinceName" => "CDMX",      //Set your state or province name
 "localityName" => "CDMX",        //Ser your city name
 "organizationName" => "ADIP",  //Set your company name
 "organizationalUnitName" => "Desarrollo de sistemas", //Set your department name
 "commonName" => "chat_socket.soluint.com",  //Set your full hostname.
 "emailAddress" => "jlvdanty@example.com"  //Set your email address
);

//create ssl cert for this scripts life.
echo "Creating SSL Cert\n";
createSSLCert($pem_file, $pem_passphrase, $pem_dn);

//setup and listen to a tcp IP/port, returning the socket stream
$socket = setupTcpStreamServer($pem_file, $pem_passphrase, $ip, $port);
echo "Listening to {$ip}:{$port} for connections\n";

//enter a loop until an exit command is received.
$exit=false;
$i=1;
while($exit==false) {

 //Accept any new connections
 $forkedSocket = stream_socket_accept($socket, "-1", $remoteIp ) or die("socket_create() failed");

 echo "New connection from $remoteIp ".print_r($forkedSocket,true)."\n";

 //start SSL on the connection
 stream_set_blocking ($forkedSocket, true); // block the connection until SSL is done.
 //echo "paso stream_set_blocking $remoteIp\n";
 stream_socket_enable_crypto($forkedSocket, true, STREAM_CRYPTO_METHOD_SSLv3_SERVER);
 echo "paso stream_socket_enable_crypto $remoteIp\n";

 //Read the command from the client. This will read 8192 bytes of data, If you need to read more you may need to increase this. However some systems will fragment the command over 8192 anyway, so you would instead need to write a loop waiting for the command input to end before proceeding.
 $command = fread($forkedSocket, 8192);
 echo "paso fread $remoteIp comando $command \n";

 //unblock connection
 stream_set_blocking ($forkedSocket, false);
 echo "paso stream_set_blocking $remoteIp\n";

 //run a switch on the command to determine what we need to do
 switch($command) {
  //exit command will cause this script to quit out
  CASE "exit";
   $exit=true;
   echo "exit command received \n";
  break;

  //hi command
  CASE "hi";
   //write back to the client a response.
   fwrite($forkedSocket, "Hello {$remoteIp}. This is our $i command run!");
   $i++;

   echo "hi command received \n";
  break;
 }

 //close the connection to the client
 fclose($forkedSocket);
}
exit(0);



function createSSLCert($pem_file, $pem_passphrase, $pem_dn) {
//create ssl cert for this scripts life.

 //Create private key
 $privkey = openssl_pkey_new();

 //Create and sign CSR
 $cert    = openssl_csr_new($pem_dn, $privkey);
 $cert    = openssl_csr_sign($cert, null, $privkey, 365);

 //Generate PEM file
 $pem = array();
 openssl_x509_export($cert, $pem[0]);
 openssl_pkey_export($privkey, $pem[1], $pem_passphrase);
 $pem = implode($pem);

 //Save PEM file
 file_put_contents($pem_file, $pem);
 chmod($pem_file, 0777);
}

function setupTcpStreamServer($pem_file, $pem_passphrase, $ip, $port) {
//setup and listen to a tcp IP/port, returning the socket stream

 //create a stream context for our SSL settings
 $context = stream_context_create();

 //Setup the SSL Options
 stream_context_set_option($context, 'ssl', 'local_cert', $pem_file);  // Our SSL Cert in PEM format
 stream_context_set_option($context, 'ssl', 'passphrase', $pem_passphrase); // Private key Password
 stream_context_set_option($context, 'ssl', 'allow_self_signed', true);
 stream_context_set_option($context, 'ssl', 'verify_peer', false);
 stream_context_set_option($context, 'ssl', 'verify_peer_name', false);

 //create a stream socket on IP:Port
 $socket = stream_socket_server("ssl://{$ip}:{$port}", $errno, $errstr, STREAM_SERVER_BIND|STREAM_SERVER_LISTEN, $context);
 if (!$socket) {
      echo "error conexion".$errno;
 }
 stream_socket_enable_crypto($socket, false);

 return $socket;
}
?>
