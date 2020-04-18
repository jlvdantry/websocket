<?php

namespace App\AdipUtils;

use App\AdipUtils\SimpleCURL;
use App\Models\CorreoTramite;

final class MandrillMail{
    
    private $curl;

    public function __construct($url = ''){
        throw new \Exception('No implementado');
        if(!SimpleCURL::isRunnable()){
            Logg::log(__METHOD__,'No se puede ejecutar una de las dependencias de esta API.', 0);
            throw new \Exception("No se puede ejecutar Mandrill si no está activada la extensión cURL");
        }
        $this->curl = new SimpleCURL;
	}
	
	public function sendMail(CorreoTramite $correo){
        $mandrillData=[
            'key' => env('MANDRILL_SECRET'),
            'message' => [
                'html' => $correo->tx_body,
                'text' => strip_tags($correo->tx_body),
                'subject' => $correo->tx_subject,
                'from_email' => env('MAIL_FROM_ADDRESS'),
                'from_name' => env('MAIL_FROM_NAME'),
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
        $this->curl->setUrl(env('MANDRILL_URL')); //
        $this->curl->setData(json_encode($mandrillData));
        $this->curl->addHeader(['name'=>'Content-Type','value'=>'application/json']);
        $this->curl->prepare();
        $resultMail = $this->curl->execute();
        $oResult = json_decode($resultMail);
		return $oResult;
	}
}