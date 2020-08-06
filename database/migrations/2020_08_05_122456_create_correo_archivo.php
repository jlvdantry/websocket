<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCorreoArchivo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t001500_correo_archivo', function (Blueprint $table) {
            $table->bigInteger('id_correo')->unsigned();
            $table->bigInteger('id_archivo')->unsigned();

            $table->foreign('id_correo')->references('id')->on('t001300_correo_app');
            $table->foreign('id_archivo')->references('id')->on('t001301_archivo_app');

            $table->primary(['id_correo','id_archivo']);


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('t001500_correo_archivo', function (Blueprint $table) {
            $table->dropForeign('t001500_correo_archivo_id_correo_foreign');
            $table->dropForeign('t001500_correo_archivo_id_archivo_foreign');
        });
        Schema::dropIfExists('t001500_correo_archivo');
    }
}
