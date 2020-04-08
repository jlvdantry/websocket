<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSesionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t001800_sesion', function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->string('tx_code',1000)->unique();
            $table->string('tx_token',1000)->unique();
            $table->string('ix_token',1000)->unique();
            $table->bigInteger('id_usuario');
            $table->string('tx_user_agent',350);
            $table->string('tx_ip',50);
            $table->string('tx_stamp_inicia',100);
            $table->string('tx_stamp_caduca',100);
            $table->integer('st_abierta');
            $table->dateTime('fh_registra');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //Schema::dropIfExists('t001800_sesion');
        DB::statement('drop table if exists t001800_sesion cascade');
    }
}
