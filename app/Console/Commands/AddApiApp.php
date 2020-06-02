<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ApiApp;
use Illuminate\Support\Str;

class AddApiApp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'llave:agregar-api-app';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Da de alta una aplicación externa para que pueda consumir el API de esta aplicación';

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
    public function handle(){

        $nb_aplicacion = $tx_descripcion = $tx_token = "";
        $this->info("** Se va a dar de alta una nueva aplicación externa **");
        while(strlen(trim($nb_aplicacion))==0){
            $nb_aplicacion = utf8_encode($this->ask("Escribe el NOMBRE de la aplicación: "));
        }
        while(strlen(trim($tx_descripcion))==0){
            $tx_descripcion = utf8_encode($this->ask("Escribe la DESCRIPCIÓN de la aplicación: "));
        }
        $tx_token = Str::random(80);
        ApiApp::create([
            'nb_aplicacion' => substr($nb_aplicacion,0,250)
            ,'tx_descripcion_app' => substr($tx_descripcion,0,250)
            ,'api_token' => $tx_token
            ,'st_activo' => 1
            ,'created_at' => date('Y-m-d H:i:s')
            ,'updated_at' => date('Y-m-d H:i:s')
        ]);

        $this->info("     [ OK ] Se ha dado de alta la aplicación.");
        $this->info("            El token de autenticación es: ".$tx_token."");
        $this->comment("            [!] El token debe ser tratado como información sensible");
        $this->info("======================================================================");
        $this->info("Consulta https://codigofuente.cdmx.gob.mx/adip.dev/php/laravel/archetype_laravel7.5_with_llavecdmx/wikis/Exponer%20API/ para obtener los detalles de implementación");
    }
}
