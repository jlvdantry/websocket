<?php

use Illuminate\Database\Seeder;
use App\Models\Permiso;

class PermisosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $p = new Permiso;
        $p->id = Permiso::CIUDADANO;
        $p->nb_permiso = Permiso::NB_CIUDADANO;
        $p->save();
        unset($p);
        
        $p = new Permiso;
        $p->id = Permiso::DESARROLLADOR;
        $p->nb_permiso = Permiso::NB_DESARROLLADOR;
        $p->save();
        unset($p);
    }
}
