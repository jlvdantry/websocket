<?php

namespace App\AdipUtils;

use App\AdipUtils\MandrillMail;
use App\Models\Correo;
use Carbon\Carbon;

final class MailFactory{
    
    private function __construct(){	}
	
	public static function sendMail(Correo $correo):Object{
        $correo->save();
        $idCorreo = $correo->id;

        $correo->nu_intentos++;
        $mail = new MandrillMail;
        $res = $mail->sendMail($correo);
        $status = $res[0]->status;
        if($status !== 'sent' && $status !== 'queued'){
            $correo->tx_reject_reason = $res[0]->reject_reason;
            $ret = (Object)[
                'success'=> FALSE,
                'rejectReason' => $res[0]->reject_reason,
                'mandrillID' => NULL,
                'correoID' => $idCorreo
            ];
        }else{
            $correo->st_enviado = 1;
            $correo->fh_enviado = Carbon::createFromFormat('d/m/Y H:i:s', date("d/m/Y H:i:s"));
            $correo->tx_mandrill_id = $res[0]->_id;
            $ret = (Object)[
                'success'=> TRUE,
                'rejectReason' => NULL,
                'mandrillID' => $res[0]->_id,
                'correoID' => $idCorreo
            ];
        }
        $correo->update();
        return $ret;
	}
}