<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Archivos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t001301_archivo_app', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nb_archivo',256);
            $table->string('tx_mime_type',150);
            $table->bigInteger('nu_tamano')->unsigned();
            $table->string('tx_uuid',50);
            $table->string('tx_sha256',100);
            $table->bigInteger('usr_alta');
            $table->timestamp('fh_borrado')->nullable();
            $table->bigInteger('usr_borra')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('t001301_archivo_app');
    }
}
