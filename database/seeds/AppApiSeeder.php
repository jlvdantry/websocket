<?php

use Illuminate\Database\Seeder;
use App\Models\ApiApp;
use Illuminate\Support\Str;

class AppApiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ApiApp::create([
            'nb_aplicacion' => 'App1 WS'
            ,'tx_descripcion_app' => 'Aplicacionde prueba'
            ,'api_token' => Str::random(80)
            ,'st_activo' => 1
            ,'created_at' => date('Y-m-d H:i:s')
            ,'updated_at' => date('Y-m-d H:i:s')
        ]);
    }
}
