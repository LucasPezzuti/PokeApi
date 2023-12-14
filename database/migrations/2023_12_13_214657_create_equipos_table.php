<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEquiposTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('equipos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombre', 100)->nullable();

            $table->unsignedBigInteger('id_entrenadores')->nullable(); 
            $table->timestamps();

            // Llave foránea
            $table->foreign('id_entrenadores')->references('id')->on('entrenadores')->onDelete('restrict')->onUpdate('restrict'); // Modificado
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('equipos');
    }
}
