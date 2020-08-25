<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Correo;
use App\AdipUtils\{Constants, MandrillMail};
use \Mail;
use Carbon\Carbon;

class LlaveEnviaCorreos extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'llave:enviar-correos';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envía los correos que están en espera de envío';

    private const FIVE_MINUTES = 5;
    private const FIVE_HOURS = 5;
    private const ONE_DAY = 1;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // Step 1: sacar los correos que no se han enviado
        $correosPendientes = Correo::where('st_enviado',Correo::NO_ENVIADO)
                            ->where('st_activo', '=', Constants::ACTIVO)->get();
        $cuantos = count($correosPendientes);
        if($cuantos==0){
            $this->info('¡Enhorabuena! No hay correos pendientes de enviar');
        }else{
            $this->info('[ INFO ] Hay '.$cuantos. ' correos pendientes de enviar.');
            $c = 1;
        // Step 2: Tratar de enviar los correos
            foreach($correosPendientes as $correito){
                $tryToSend = FALSE;
                $this->comment('     Procesando: '.$correito->tx_to.' ('.$c.' de '.$cuantos.')' );
                $carbonTS = Carbon::now();
                $lastTry = $correito->updated_at;
                //
                if(NULL===$correito->fh_proximo_intento){
                    $tryToSend = TRUE;
                }elseif($carbonTS->gte($correito->fh_proximo_intento)){
                    $tryToSend = TRUE;
                }
                if($tryToSend){
                    $mail = new MandrillMail;
                    $res = $mail->sendMail($correito);
                    if(is_array($res) && isset($res[0])){
                    }else{
                        $r = $res;
                        unset($res);
                        $res[0] = $r;
                        $res[0]->reject_reason = $r->message;
                    }
                    $status = $res[0]->status;
                    if($status !== 'sent'){
                        switch($correito->nu_intentos){
                            case 0:{
                                $correito->fh_proximo_intento = $carbonTS->addMinutes(self::FIVE_MINUTES);
                                break;
                            }
                            case 1:{
                                $correito->fh_proximo_intento = $carbonTS->addHours(self::FIVE_HOURS);
                                break;                
                            }
                            case 2:{
                                $correito->fh_proximo_intento = $carbonTS->addDays(self::ONE_DAY);
                                break;
                            }
                            default:{
                                $correito->st_activo = 0;
                            }
                        }
                        $correito->nu_intentos++;
                        $correito->tx_reject_reason = $res[0]->reject_reason;
                        $this->error('      -> Failed: '.$res[0]->reject_reason);
                    }else{
                        $correito->nu_intentos++;
                        $correito->st_enviado = 1;
                        $correito->st_activo = 0;
                        //$correito->fh_enviado = date("d/m/Y H:i:s");
                        $correito->fh_enviado = Carbon::createFromFormat('d/m/Y H:i:s', date("d/m/Y H:i:s"));
                        $correito->tx_mandrill_id = $res[0]->_id;
                        $this->info('      -> OK: ID de correo = '.$res[0]->_id);
                    }
                    $correito->update();
                }else{
                    $this->info('      -> Skipped');
                }
                $c++;
            }
        }
    }
}
