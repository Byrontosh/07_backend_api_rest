<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wards', function (Blueprint $table) {
            // ID para la tabla de la BDD
            $table->id();

            // columnas para la tabla BDD
            $table->string('name', 45);
            $table->string('location', 45);
            $table->boolean('state')->default(true);

            // columnas que seran podran aceptar regitros null para la tabla de la BDD
            $table->string('description')->nullable();

            // columnas especiales para la tabla de la BDD
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
        Schema::dropIfExists('wards');
    }
};
