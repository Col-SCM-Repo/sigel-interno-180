<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ResponsableVacante extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('responsable_vacante', function (Blueprint $table) {
            $table->increments('id');
            $table->string('codigo',45);
            $table->enum('estado',['activo','inactivo']);
            //Relaciones
            $table->integer('responsable_id')->unsigned();
            $table->foreign('responsable_id')->references('id')->on('responsables')->onUpdate('no action')->onDelete('no action');

            $table->integer('vacante_id')->unsigned();
            $table->foreign('vacante_id')->references('MP_VAC_ID')->on('MP_VACANTES')->onUpdate('no action')->onDelete('no action');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('responsable_vacante');
    }
}
