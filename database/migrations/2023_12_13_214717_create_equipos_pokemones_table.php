<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEquiposPokemonesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('equipos_pokemones', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_equipos')->nullable(); 
            $table->unsignedBigInteger('id_pokemones')->nullable();
            $table->tinyInteger('orden')->unsigned()->nullable(); 
            $table->timestamps();

            // Llaves foráneas
            $table->foreign('id_equipos')->references('id')->on('equipos')->onDelete('restrict')->onUpdate('restrict'); // Modificado
            $table->foreign('id_pokemones')->references('id')->on('pokemones')->onDelete('restrict')->onUpdate('restrict'); // Modificado
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('equipos_pokemones');
    }
}
