<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFhProximoIntentoToT001300CorreoApp extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('t001300_correo_app', function (Blueprint $table) {
            $table->smallInteger('st_activo')->unsigned()->default(1);
            $table->timestamp('fh_proximo_intento')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('t001300_correo_app', function (Blueprint $table) {
            $table->dropColumn('st_activo');
            $table->dropColumn('fh_proximo_intento');
        });
    }
}
