<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogSesionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t001801_sesion_log', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('ix_token',1000);
            $table->string('tx_mensaje',500);
            $table->datetime('fh_registra');

            // Relacion
            $table->foreign('ix_token')->references('ix_token')->on('t001800_sesion')->onDelete('cascade');

            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //Schema::dropIfExists('t001801_sesion_log');
        DB::statement('drop table if exists t001801_sesion_log cascade');
    }
}
