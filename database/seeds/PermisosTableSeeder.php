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
        $p->id = Permiso::ROL_DEMO;
        $p->nb_permiso = Permiso::NB_ROL_DEMO;
        $p->save();
        unset($p);
        
    }
}
