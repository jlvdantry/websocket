<?php

namespace App\AdipUtils;

use App\Models\{User, Permiso};
use App\AdipUtils\ErrorLoggerService as Logg;
use App\Exceptions\LlaveException;
use Log;

final class LlaveCDMX{

    /**
     * ID de cliente en LlaveCDMX
     * @var String
     */
    private $clientId;


    /**
     * URL a la que redirecciona despues de iniciar sesion
     * @var String
     */
    private $redirectTo;
    
    
    /**
     * Descripción del sistema
     * @var String
     */
    private $clientDescription;
    
    
    /**
     * URL del servidor LlaveCDMX
     * @var String
     */
    private $authURI;
    
    
    /**
     * URL para obtener token de autenticacion en Llave
     * @var String
     */
    private $tokenURI;
    
    
    /**
     * URL para obtener info del usuario en Llave
     * @var String
     */
    private $userURI;
    
    
    /**
     * URL para obtener los roles del usuario
     * @var String
     */
    private $rolesURI;
    
    
    /**
     * Secret code del cliente Llave
     * @var String
     */
    private $secret;
    
    
    /**
     * Domain user Llave
     * @var String
     */
    private $authUser;


    /**
     * Domain password Llave
     * @var String
     */
    private $authPassword;


    /**
     * Crea una instancia de LlaveCDMX
     * 
     * @throws App\Exceptions\LlaveException
     */
    public function __construct(){

            $this->clientId = config('llave.idcliente');
            $this->redirectTo = config('llave.redirect', route('welcome'));
            $this->clientDescription = config('app.name','Generic Client Llave CDMX');
            $this->authURI = config('llave.server');
            $this->tokenURI = config('llave.gettoken');
            $this->userURI = config('llave.getuser');
            $this->rolesURI = config('llave.getroles');
            $this->secret = config('llave.secret');
            $this->authUser = config('llave.domainuser');
            $this->authPassword =config('llave.domainpassword');

            if(strlen(trim($this->clientId))==0)     throw new LlaveException('No se definió ID de cliente para Llave CDMX');
            if(strlen(trim($this->authURI))==0)      throw new LlaveException('No se definió URL de redireccionamiento para Llave CDMX');
            if(strlen(trim($this->tokenURI))==0)     throw new LlaveException('No se definió URL de token para Llave CDMX');
            if(strlen(trim($this->userURI))==0)      throw new LlaveException('No se definió URL de usuario para Llave CDMX');
            if(strlen(trim($this->rolesURI))==0)     throw new LlaveException('No se definió URL de roles para Llave CDMX');
            if(strlen(trim($this->secret))==0)       throw new LlaveException('No se definió palabra secreta de cliente para Llave CDMX');
            if(strlen(trim($this->authUser))==0)     throw new LlaveException('No se definió usuario Basic Auth para Llave CDMX');
            if(strlen(trim($this->authPassword))==0) throw new LlaveException('No se definió contraseña Basic Auth para Llave CDMX');

    }


    /**
     * Intenta autenticar en Llave
     * 
     * @param String $code
     * @return Object
     * @throws LlaveException
     */
    public function authenticate(String $kod):Object{

            if(strlen(trim($kod))==0){
                Logg::log(__METHOD__,'No se envió ningún código al método authenticate()', 500);
                throw new LlaveException('No se envió ningún código al método authenticate()');
            }
            $my_cURL = new SimpleCURL;
            $my_cURL->setUrl($this->tokenURI);
            $my_cURL->setData(json_encode($this->createAuthPacket($kod)));
            $my_cURL->addHeader(['name'=>'Content-Type','value'=>'application/json']);
            $my_cURL->useAuthBasic($this->authUser,$this->authPassword);
            $my_cURL->prepare();
            $resultToken = $my_cURL->execute();
            //Log::info('SimpleCURL: '.$my_cURL);
            $oResult = json_decode($resultToken);
            if(NULL===$oResult){
                Logg::log(__METHOD__,'LlaveCDMX devolvió un objeto vacío a la hora de solicitar el primer token', 0);
                die('<h3>Authentication required (LlaveCDMX)</h3>');
            }
            return $oResult;

    }


    /**
     * Obtiene los datos del usuario que inició sesión
     * 
     * @param String $tokeen
     * @return NULL|User
     * @throws App\Exceptions\LlaveException
     */
    public function getUser(String $tokeen):?User{

            if(strlen(trim($tokeen))==0){
                Logg::log(__METHOD__,'No se envió ningún token al método getUser()', 500);
                throw new LlaveException('No se envió ningún token al método getUser()');
            }
            $ret=NULL;
            $my_cURL = new SimpleCURL;
            $my_cURL->setUrl($this->userURI);
            $my_cURL->isGet();
            $my_cURL->setData('');
            $my_cURL->addHeader(['name'=>'accessToken','value'=>$tokeen]);
            $my_cURL->useAuthBasic($this->authUser,$this->authPassword);
            $my_cURL->prepare();
            $resultUser = $my_cURL->execute();
            $oResult = json_decode($resultUser,TRUE);
            if(is_array($oResult)){
                $ret = new User($oResult);
            }
            return  $ret;

    }

    
    /**
     * Obtiene los roles del usuario que inició sesión
     * 
     * @param String $tokeen
     * @param User $u
     * @return ArrayList
     * @throws App\Exceptions\LlaveException
     */
    public function getRoles(String $tokeen, User $u):ArrayList{

            if(strlen(trim($tokeen))==0){
                Logg::log(__METHOD__,'No se envió ningún token al método getRoles()', 500);
                throw new LlaveException('No se envió ningún token al método getRoles()');
            }
            $ret=new ArrayList;
            // Buscar los que manda llave
            $dataSend = '{"idUsuario":'.$u->idUsuario.', "idSistema":"'.$this->clientId.'"}';
            $my_cURL = new SimpleCURL;
            $my_cURL->setUrl($this->rolesURI);
            $my_cURL->setData($dataSend);
            $my_cURL->addHeader(['name'=>'accessToken','value'=>$tokeen]);
            $my_cURL->addHeader(['name'=>'Content-Type','value'=>'application/json']);
            $my_cURL->useAuthBasic($this->authUser,$this->authPassword);
            $my_cURL->prepare();
            $resultRoles = $my_cURL->execute();
            $oTemp = json_decode($resultRoles);
            if(is_array($oTemp)){
                for($r=0;$r<count($oTemp);$r++){
                    $permiso_user = Permiso::where('nb_permiso', trim($oTemp[$r]->rol))->first();
                    if(NULL === $permiso_user){
                        //Logg::log(__METHOD__,'Permiso LlaveCDMX no reconocido '.$oTemp[$r]->rol, 400);
                        throw new LlaveException('El sistema LlaveCDMX ha enviado un permiso que esta aplicación no reconoce ('.$oTemp[$r]->rol.')');
                    }else{
                        $ret->add($permiso_user);
                    }
                }
            }
            // Todos son ciudadanos
            $citizen = Permiso::where('nb_permiso', Permiso::NB_CIUDADANO)->first();
            if(NULL === $citizen){
                throw new LlaveException('No hay permiso de ciudadano. Si esta es una App nueva, asegúrate de haber ejecutado el seeder de permisos. (php artisan db:seed --class=PermisosTableSeeder');
            }
            $ret->add($citizen);
            return  $ret;

    }

    
    /**
     * Devuelve el ID de cliente de Llave
     * 
     * @return String
     */
    public function getClientId():String{
		return $this->clientId;
	}

    
    /**
     * Devuelve la URL de redirección
     * 
     * @return String
     */
    public function getRedirectTo():String{
		return $this->redirectTo;
	}

    
    /**
     * Devuelve la descripción de cliente de Llave
     * 
     * @return String
     */
    public function getClientDescription():String{
		return $this->clientDescription;
	}

    
    /**
     * Devuelve la URL del servicio de autenticación de Llave
     * 
     * @return String
     */
    public function getAuthURI():String{
		return $this->authURI;
	}

    
    /**
     * Devuelve la URL de obtención de token de Llave
     * 
     * @return String
     */
    public function getTokenURI():String{
		return $this->tokenURI;
    }

    
    /**
     * Devuelve la URL para obtener el usuario autenticado
     * en Llave
     * 
     * @return String
     */
    public function getUserURI():String{
		return $this->userURI;
    }

    
    /**
     * Devuelve el secret code de la aplicación
     * 
     * @return String
     */
    public function getSecret():String{
		return $this->secret;
    }
    
    
    /**
     * Crea el "paquete de autenticación" para iniciar sesión en LlaveCDMX
     * 
     * @param String $c
     * @return Object
     */
    private function createAuthPacket(String $c){
        return (object)[
            'grantType'=>"authorization_code",
            'code'=> $c,
            'redirectUri'=>$this->redirectTo,
            'clientId'=> $this->clientId,
            'clientSecret'=>$this->secret
        ];
    }

}
