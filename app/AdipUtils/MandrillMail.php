<?php

namespace App\AdipUtils;

use App\AdipUtils\SimpleCURL;
use App\Models\Correo;

final class MandrillMail{
    
    private $curl;

    public function __construct($url = ''){
        if(!SimpleCURL::isRunnable()){
            Logg::log(__METHOD__,'No se puede ejecutar una de las dependencias de esta API.', 0);
            throw new \Exception("No se puede ejecutar Mandrill si no está activada la extensión cURL");
        }
        $this->curl = new SimpleCURL;
	}
	
	public function sendMail(Correo $correo):Array{
        $mandrillData=[
            'key' => config('engine.mandrillsecret'),
            'message' => [
                'html' => $correo->tx_body,
                'text' => strip_tags($correo->tx_body),
                'subject' => $correo->tx_subject,
                'from_email' => $correo->tx_from,
                'from_name' => config('mail.from.name'),
                'to' => [0 => [
                    'email' => $correo->tx_to,
                    'name' => '',
                    'type' => 'to'
                    ]
                ],
                'important' => $correo->nu_priority===1,
            ],
            'async' => FALSE
        ];
        $this->curl->setUserAgent('Mandrill-Curl/1.0');
        $this->curl->setUrl(config('engine.mandrillurl')); //
        $this->curl->setData(json_encode($mandrillData));
        $this->curl->addHeader(['name'=>'Content-Type','value'=>'application/json']);
        $this->curl->prepare();
        $resultMail = $this->curl->execute();
        $oResult = json_decode($resultMail);
		return $oResult;
	}
}