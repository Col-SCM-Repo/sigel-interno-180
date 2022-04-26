<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableCarnet extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carnet', function (Blueprint $table) {
            $table->increments('id');
            $table->string('path')->nullable();
            $table->enum('parte',['frente','reverso'])->nullable();
            //Relaciones
            $table->integer('anio_id')->unsigned();
            $table->foreign('anio_id')->references('MP_ANIO_ID')->on('MP_ANIOACADEMICO')->onUpdate('no action')->onDelete('no action');
            $table->integer('local_id')->unsigned();
            $table->foreign('local_id')->references('MP_LOC_ID')->on('MP_LOCAL')->onUpdate('no action')->onDelete('no action');
            $table->integer('nivel_id')->unsigned();
            $table->foreign('nivel_id')->references('MP_NIV_ID')->on('MP_NIVEL')->onUpdate('no action')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('carnet');
    }
}
