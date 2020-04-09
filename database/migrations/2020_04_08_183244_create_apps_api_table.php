<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppsApiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('apps_api', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nb_aplicacion', 250);
            $table->string('tx_descripcion_app', 250);
            $table->string('api_token', 80)->unique();
            $table->tinyInteger('st_activo')->unsigned()->defaut(1);
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
        Schema::dropIfExists('apps_api');
    }
}
