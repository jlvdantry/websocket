<?php

namespace App\AdipUtils;

use App\Models\{User, Permiso};
use App\AdipUtils\ErrorLoggerService as Logg;

final class LlaveCDMX{

    private $clientId;
    private $redirectTo;
    private $clientDescription;
    private $authURI;
    private $tokenURI;
    private $userURI;
    private $rolesURI;
    private $secret;
    private $authUser;
    private $authPassword;

    /**
     * 
     */
    public function __construct(){
        try{
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

            if(strlen(trim($this->clientId))==0)     throw new \Exception('No se definió ID de cliente para Llave CDMX');
            if(strlen(trim($this->authURI))==0)      throw new \Exception('No se definió URL de redireccionamiento para Llave CDMX');
            if(strlen(trim($this->tokenURI))==0)     throw new \Exception('No se definió URL de token para Llave CDMX');
            if(strlen(trim($this->userURI))==0)      throw new \Exception('No se definió URL de usuario para Llave CDMX');
            if(strlen(trim($this->rolesURI))==0)     throw new \Exception('No se definió URL de roles para Llave CDMX');
            if(strlen(trim($this->secret))==0)       throw new \Exception('No se definió palabra secreta de cliente para Llave CDMX');
            if(strlen(trim($this->authUser))==0)     throw new \Exception('No se definió usuario Basic Auth para Llave CDMX');
            if(strlen(trim($this->authPassword))==0) throw new \Exception('No se definió contraseña Basic Auth para Llave CDMX');
        }catch(\Exception $e){
            Logg::log(__METHOD__,$e->getMessage(), 500);
            abort(500, $e->getMessage());
        }
    }

    public function authenticate(String $kod):Object{
        if(strlen(trim($kod))==0){
            Logg::log(__METHOD__,'No se envió ningún código al método authenticate()', 500);
            throw new \Exception('No se envió ningún código al método authenticate()');
        }
        $my_cURL = new SimpleCURL;
        $my_cURL->setUrl($this->tokenURI);
        $my_cURL->setData(json_encode($this->createAuthPacket($kod)));
        $my_cURL->addHeader(['name'=>'Content-Type','value'=>'application/json']);
        $my_cURL->useAuthBasic($this->authUser,$this->authPassword);
        $my_cURL->prepare();
        $resultToken = $my_cURL->execute();
        $oResult = json_decode($resultToken);
        if(NULL===$oResult){
            Logg::log(__METHOD__,'LlaveCDMX devolvió un objeto vacío a la hora de solicitar el primer token', 0);
            die('<h3>Authentication required (LlaveCDMX)</h3>');
        }

        return $oResult;
    }

    public function getUser(String $tokeen):?User{
        if(strlen(trim($tokeen))==0){
            Logg::log(__METHOD__,'No se envió ningún token al método getUser()', 500);
            throw new \Exception('No se envió ningún token al método getUser()');
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

    public function getRoles(String $tokeen, User $u):ArrayList{
        if(strlen(trim($tokeen))==0){
            Logg::log(__METHOD__,'No se envió ningún token al método getRoles()', 500);
            throw new \Exception('No se envió ningún token al método getRoles()');
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
                $permiso_user = Permiso::where('nb_permiso', $oTemp[$r]->rol)->first();
                if(NULL === $permiso_user){
                    Logg::log(__METHOD__,'Permiso LlaveCDMX no reconocido '.$oTemp[$r]->rol, 400);
                    abort(400, 'El sistema LlaveCDMX ha enviado un permiso que esta aplicación no reconoce ('.$oTemp[$r]->rol.')');
                }else{
                    $ret->add($permiso_user);
                }
            }
        }
        // Todos son ciudadanos
        $citizen = Permiso::where('nb_permiso', Permiso::NB_CIUDADANO)->first();
        if(NULL === $citizen){
            abort(500, 'No hay permiso de ciudadano. Si esta es una App nueva, asegúrate de haber ejecutado el seeder de permisos. (php artisan db:seed --class=PermisosTableSeeder');
        }
        $ret->add($citizen);
        return  $ret;
    }

	public function getClientId():String{
		return $this->clientId;
	}

	public function getRedirectTo():String{
		return $this->redirectTo;
	}

	public function getClientDescription():String{
		return $this->clientDescription;
	}

	public function getAuthURI():String{
		return $this->authURI;
	}

	public function getTokenURI():String{
		return $this->tokenURI;
    }

	public function getUserURI():String{
		return $this->userURI;
    }

    public function getSecret():String{
		return $this->secret;
    }
    
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
