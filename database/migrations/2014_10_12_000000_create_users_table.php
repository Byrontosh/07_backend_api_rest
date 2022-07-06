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
        Schema::create('users', function (Blueprint $table) {
            // ID para la tabla de la BDD
            $table->id();

            // columnas para la tabla BDD
            $table->string('first_name', 50);
            $table->string('last_name', 50);
            $table->string('personal_phone', 10);
            $table->string('address', 50);
            $table->string('password');
            $table->boolean('state')->default(true);

            // columnas que seran unicas para la tabla de la BDD
            $table->string('email')->unique();
            $table->string('username', 50)->unique();

            // columnas que seran podran aceptar regitros null para la tabla de la BDD
            $table->string('home_phone', 9)->nullable();
            $table->date('birthdate')->nullable();
            $table->timestamp('email_verified_at')->nullable();

            // columnas especiales para la tabla de la BDD
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
};
