<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotaAcademicaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nota_academica', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('codigo')->nullable();
            $table->enum('exonerado', ['si', 'no'])->nullable();
            $table->string('resolucion_directorial_exo',50)->nullable();
            $table->integer('u1n1')->nullable();
            $table->integer('u1n2')->nullable();
            $table->integer('u1n3')->nullable();
            $table->integer('u1n4')->nullable();
            $table->integer('u1n5')->nullable();
            $table->integer('u1n6')->nullable();
            $table->integer('pu1')->nullable();
            $table->integer('u2n1')->nullable();
            $table->integer('u2n2')->nullable();
            $table->integer('u2n3')->nullable();
            $table->integer('u2n4')->nullable();
            $table->integer('u2n5')->nullable();
            $table->integer('u2n6')->nullable();
            $table->integer('pu2')->nullable();
            $table->integer('u3n1')->nullable();
            $table->integer('u3n2')->nullable();
            $table->integer('u3n3')->nullable();
            $table->integer('u3n4')->nullable();
            $table->integer('u3n5')->nullable();
            $table->integer('u3n6')->nullable();
            $table->integer('pu3')->nullable();
            $table->integer('u4n1')->nullable();
            $table->integer('u4n2')->nullable();
            $table->integer('u4n3')->nullable();
            $table->integer('u4n4')->nullable();
            $table->integer('u4n5')->nullable();
            $table->integer('u4n6')->nullable();
            $table->integer('pu4')->nullable();
            $table->integer('et')->nullable();
            $table->integer('ptn')->nullable();
            $table->string('ptc',4)->nullable();
            $table->integer('puntaje')->nullable();
            $table->integer('merito')->nullable();
            //Relaciones
            $table->integer('matricula_id')->unsigned();
            $table->foreign('matricula_id')->references('MP_MAT_ID')->on('MP_MATRICULA')->onUpdate('no action')->onDelete('no action');

            $table->integer('responsable_vacante_id')->unsigned();
            $table->foreign('responsable_vacante_id')->references('id')->on('responsable_vacante')->onUpdate('no action')->onDelete('no action');

            $table->integer('periodo_id')->unsigned();
            $table->foreign('periodo_id')->references('id')->on('periodos')->onUpdate('no action')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('nota_academica');
    }
}
