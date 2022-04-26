<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Empleados extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empleados', function (Blueprint $table) {
            $table->increments('id');
            $table->string('apellidos', 200);
            $table->string('nombres', 200);
            $table->string('foto', 200)->nullable();
            $table->enum('genero',['masculino','femenino']);
            $table->string('documento', 15)->unique();
            $table->enum('tipo_documento',['dni','carnet_extrangeria', 'pasaporte','otros']);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('empleados');

    }
}
