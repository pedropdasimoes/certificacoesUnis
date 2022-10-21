<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormandosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('formandos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome');
            $table->bigInteger('cpf');
            $table->string('email');
            $table->text('cursos');
            $table->text('redes');
            $table->text('badges');
            $table->string('password');
            $table->text('profile_photo_path')->nullable();




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
        Schema::dropIfExists('formandos');
    }
}
