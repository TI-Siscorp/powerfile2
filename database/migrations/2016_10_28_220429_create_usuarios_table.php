<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsuariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sgd_usuarios', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('lastname',250);
            $table->string('cedula',12);
            $table->string('login');
            $table->string('email')->unique();
            $table->string('password');     
            $table->text('direccion');
            $table->string('celular',12);
            $table->string('fijo',12);
            $table->string('avatar',250);
            $table->integer('id_estado')->unsigned();
                       
            $table->integer('id_rol')->unsigned();
            
           /* $table->foreign('id_estado')
            ->references('id_estado')->on('sgd_estados')
            ->onDelete('cascade');
            
            $table->foreign('id_rol')
            ->references('id_rol')->on('sgd_rols')
            ->onDelete('cascade');*/
            
            
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
        Schema::dropIfExists('sgd_usuarios');
    }
}
