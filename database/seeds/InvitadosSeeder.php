<?php

use Illuminate\Database\Seeder;
use App\Models\Invitado;

class InvitadosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Invitado::create(
            [
                'tx_apellido_paterno' => 'Invitado'
                ,'tx_apellido_materno' => 'Arquetipo'
                ,'tx_nombre' => 'Usuario'
                ,'email' => 'invitado@adip.io'
                ,'password' => bcrypt('include soap transfer plastic label')
            ]
        );
    }
}
