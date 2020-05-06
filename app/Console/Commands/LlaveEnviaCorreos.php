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
        $correosPendientes = Correo::where('st_enviado',Correo::NO_ENVIADO)->get();
        $cuantos = count($correosPendientes);
        if($cuantos==0){
            $this->info('¡Enhorabuena! No hay correos pendientes de enviar');
        }else{
            $this->info('[ INFO ] Hay '.$cuantos. ' correos pendientes de enviar.');
            $c = 1;
        // Step 2: Tratar de enviar los correos
            foreach($correosPendientes as $correito){
                $this->comment('     Procesando: '.$correito->tx_to.' ('.$c.' de '.$cuantos.')' );
                //
                $mail = new MandrillMail;
                $correito->nu_intentos++;
                $res = $mail->sendMail($correito);
                $status = $res[0]->status;
                if($status !== 'sent'){
                    $correito->tx_reject_reason = $res[0]->reject_reason;
                    $this->error('      -> Failed: '.$res[0]->reject_reason);
                }else{
                    $correito->st_enviado = 1;
                    $correito->fh_enviado = Carbon::createFromFormat('d/m/Y H:i:s', date("d/m/Y H:i:s"));
                    $correito->tx_mandrill_id = $res[0]->_id;
                    $this->info('      -> OK: ID de correo = '.$res[0]->_id);
                }
                $correito->update();
                $c++;
            }
        }
    }
}
