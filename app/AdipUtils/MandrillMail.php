<?php

namespace App\AdipUtils;

use App\AdipUtils\SimpleCURL;
use App\AdipUtils\FileService;
use App\Models\Correo;

final class MandrillMail{
    
    /**
     * Instancia de SimpleCURL para comunicacion con
     * servicio de Mandrill
     * 
     * @var SimpleCURL
     */
    private $curl;

    /**
     * Crera una nueva instancia de MandrillMail
     * 
     * @throws \Exception
     */
    public function __construct($url = ''){
        if(!SimpleCURL::isRunnable()){
            Logg::log(__METHOD__,'No se puede ejecutar una de las dependencias de esta API.', 0);
            throw new \Exception("No se puede ejecutar Mandrill si no está activada la extensión cURL");
        }
        $this->curl = new SimpleCURL;
	}
	
    /**
     * Envía un mail a la cola de envío de Mandrill
     * 
     * @param Correo
     * @return Array
     */
    public function sendMail(Correo $correo):Array{
        $att = $this->prepareAttachments($correo);
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
                'attachments' => $att,
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
    
    
    /**
     * Verifica si un correo tiene datos adjuntos y los prepara para el envío
     * al correo dado en $c
     * 
     * @param Correo $c
     * @return Array
     */
    private function prepareAttachments(Correo $c):Array{
        $at = [];
        if(count($c->archivos)===0) return [];
        $adjuntos = $c->archivos;
        foreach($adjuntos as $adjunto){
            $at[] = [
                'type' => $adjunto->tx_mimetype,
                'name' => $adjunto->nb_archivo,
                'content' => base64_encode(file_get_contents(FileService::getFile($adjunto->tx_uuid)->real_path))
            ];
        }
        return $at;
    }
}