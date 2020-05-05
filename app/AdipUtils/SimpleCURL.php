<?php

namespace App\AdipUtils;

use App\AdipUtils\ErrorLoggerService as Logg;

final class SimpleCURL{
    
	private $url;
	private $userAgent;
	private $method;
	private $caInfo;

	private $headers;
    private $cookies;
    
    private $cURL_executor;
	private $data;
	private $isPrepared;

	private $authBasicData;
	private $useAuthBasic;


    public function __construct($url = ''){
		$this->url = $url;
        $this->userAgent = 'Mozilla/5.0 (Windows NT 10.0; WOW64) ADIP/CDMX(Simple cURL Client)';
        $this->method = 'POST';
		$this->caInfo = '';
		
        $this->headers = [];
        $this->cookies = [];

        $this->cURL_executor = curl_init();
		$this->data=NULL;
		$this->isPrepared = FALSE;

		$this->useAuthBasic = FALSE;
		$this->authBasicData = [];
	}
	
	public function setUrl(String $url){
		$this->url = $url;
	}

	public function setUserAgent(String $ua){
		$this->userAgent = $ua;
	}

    public function isGet(){
		$this->method = 'GET';
	}

    public function useAuthBasic(String $username ='', String $password=''){
		$this->useAuthBasic = TRUE;
		$this->authBasicData = ['username' => $username, 'password'=>$password];
	}
	
	public function setCaInfo(String $cainf){
		$this->caInfo = $cainf;
	}

    public function addHeader(Array $header){
		if(is_array($header) && isset($header['name'], $header['value'])){
			if(strlen(trim($header['name'])) == 0 || strlen(trim($header['value'])) == 0 ){
				throw new \Exception('No se puede agregar un encabezado sin nombre o sin valor');
			}else{
				$this->headers[]=$header;
			}
		}else{
			throw new \Exception('El formato para el array del encabezado no es correcto. Se debe usar ["name" => $nombre, "value"=>$value]');
		}
	}

    public function addCookie(Array $cookie){
		if(is_array($cookie) && isset($cookie['name'], $cookie['value'])){
			if(strlen(trim($cookie['name'])) == 0 || strlen(trim($cookie['value'])) == 0 ){
				throw new \Exception('No se puede agregar una cookie sin nombre o sin valor');
			}else{
				$this->cookies[]=$cookie;
			}
		}else{
			throw new \Exception('El formato para el array de la cookie no es correcto. Se debe usar ["name" => $nombre, "value"=>$value]');
		}
	}
	
	public function setData($strData){
		$this->data=$strData;
	}

	public function prepare(){
		// Validar que traiga URL y que sea válida
		if(strlen(trim($this->url))==0 ){
			throw new \Exception ('Se requiere una URL para ejecutar cURL');
		}else{
			if (!(filter_var($this->url, FILTER_VALIDATE_URL))) {
				throw new \Exception ($this->url. 'no es una URL válida');
			}
		}
		// Poner certificado en HTTPS
		if(FALSE!==strpos($this->url,'https://')){
			if($this->caInfo == ''){
				curl_setopt($this->cURL_executor, CURLOPT_SSL_VERIFYPEER, FALSE);
				//throw new \Exception('No se estableció el valor de CA Info. Este valor es obligatorio cuando se usa HTTPS ');
			}else{
				curl_setopt ($this->cURL_executor, CURLOPT_CAINFO, $this->caInfo);
			}
		}
		// Valida que curl se haya iniciado
		if(FALSE===$this->cURL_executor){
			throw new \Exception('No se pudo iniciar cURL. '.curl_error($this->cURL_executor));
		}else{
			curl_setopt($this->cURL_executor, CURLOPT_RETURNTRANSFER, TRUE);
			curl_setopt($this->cURL_executor, CURLOPT_VERBOSE, FALSE);
			curl_setopt($this->cURL_executor, CURLOPT_HEADER, FALSE);
			curl_setopt($this->cURL_executor, CURLOPT_CONNECTTIMEOUT, 10); 
			curl_setopt($this->cURL_executor, CURLOPT_TIMEOUT, 28);

			// Valida el metodo a enviar, GET o POST
			if($this->method == 'GET'){
				$this->data =
					strlen(trim($this->data))>0?
						substr($this->data,0,1)!='?'?'?'.$this->data:$this->data:
						'';
				curl_setopt($this->cURL_executor, CURLOPT_URL, $this->url . $this->data);
			}else{ // Default: POST
				curl_setopt($this->cURL_executor, CURLOPT_URL, $this->url);
				curl_setopt($this->cURL_executor, CURLOPT_CUSTOMREQUEST, "POST");
				curl_setopt($this->cURL_executor, CURLOPT_POSTFIELDS, $this->data);
				if(is_string($this->data)){
					$this->addHeader(['name' => 'Content-Length', 'value' => strlen($this->data)]);
				}
			}
		}
		// Prepara headers
		$arrCurlHeaders = [];
		for($h=0;$h<count($this->headers);$h++){
			$arrCurlHeaders[] = $this->headers[$h]['name'] . ': ' . $this->headers[$h]['value'];
		}
		// Prepara cookies
		$strCurlCookies = '';
		for($c=0;$c<count($this->cookies);$c++){
			$strCurlCookies .= $this->cookies[$c]['name'] . '=' . $this->cookies[$c]['value'] . ';';
		}
		if(count($this->cookies)>0){
			$arrCurlHeaders[] = 'Cookie: '.$strCurlCookies;
		}
		curl_setopt($this->cURL_executor, CURLOPT_HTTPHEADER, $arrCurlHeaders);
		
		// User Agent
		curl_setopt($this->cURL_executor, CURLOPT_USERAGENT, $this->userAgent);

		// auth basic
		if($this->useAuthBasic){
			if(isset($this->authBasicData['username']) && isset($this->authBasicData['password'])){
				curl_setopt($this->cURL_executor, CURLOPT_USERPWD, $this->authBasicData['username'] . ":" . $this->authBasicData['password']);
			}else{
				throw new \Exception ('Se debe especificar usuario y contraseña de Basic Auth');
			}
		}
		$this->isPrepared = TRUE;
	}

	public function isPrepared():bool{
		return $this->isPrepared;
	}

	public function execute(){
		if($this->isPrepared()){
			$ret = curl_exec($this->cURL_executor);
			if($ret  === FALSE){
				$l = Logg::log(__METHOD__,$this.' '.curl_error($this->cURL_executor), 500);
				abort(500, 'Falló la ejecución de SimpleCURL');
			}
		}else{
			throw new \Exception('No se debe llamar a execute() antes de prepare()');
		}
		return $ret;
	}

    public function __destruct(){
        if($this->cURL_executor){
			curl_close($this->cURL_executor);
        }
	}
	
	public function __toString(){
		return '{"Simple cURL":{"url": "'.$this->url.'","userAgent":"'.$this->userAgent.'","method":"'.$this->method.'","isPrepared": "'.$this->isPrepared.'","useAuthBasic":"'.$this->useAuthBasic.'"}}';
	}

    public static function isRunnable():bool{
        return
            function_exists('curl_init')
            && function_exists('curl_setopt')
            && function_exists('curl_exec')
            && function_exists('curl_error')
            && function_exists('curl_close')
        ;
    }
}
