<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UsuarioPermiso extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permiso_user', function (Blueprint $table) {
            $table->integer('id_permiso')->unsigned();
            $table->integer('id_usuario')->unsigned();
            // Relacion
            $table->foreign('id_usuario')->references('idUsuario')->on('users')->onDelete('cascade');
            $table->foreign('id_permiso')->references('id')->on('permisos');
            $table->primary(['id_usuario', 'id_permiso']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //Schema::dropIfExists('permiso_user');
        DB::statement('drop table if exists permiso_user cascade');
    }
}
