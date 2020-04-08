<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigInteger('idUsuario')->unsigned();
            $table->string('login',150)->unique();
            $table->string('nombre',100);
            $table->string('primerApellido',100);
            $table->string('segundoApellido',100);
            $table->string('telVigente',10)->nullable();
            $table->string('curp',18)->unique();
            $table->datetime('fechaNacimiento');
            $table->string('sexo',25);
            $table->integer('idEstadoNacimiento')->unsigned();
            $table->string('estadoNacimiento',50);
            $table->integer('idRolUsuario')->unsigned()->nullable();
            $table->string('descripcionRol',100)->nullable();
            
            $table->primary('idUsuario');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
