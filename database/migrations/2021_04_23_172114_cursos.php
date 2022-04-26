<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Cursos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cursos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('curso',100);
            $table->string('icono',45)->nullable();
            $table->string('color',45)->nullable();
            $table->enum('estado',['activo','inactivo'])->nullable();

            //Relaciones
            $table->integer('area_academica_id')->unsigned();
            $table->foreign('area_academica_id')->references('id')->on('area_academica')->onUpdate('no action')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cursos');
    }
}
