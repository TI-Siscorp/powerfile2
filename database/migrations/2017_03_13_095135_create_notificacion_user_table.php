<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificacionUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    	Schema::create('sgd_notificacion_usuarios', function (Blueprint $table) {
    		$table->increments('id_notifica');
    		$table->integer('id_documento')->unsigned(); 
    		$table->integer('id_usuario')->unsigned(); 
    		$table->integer('id_estado')->unsigned();
    		 
    		/*$table->foreign('id_estado')
    		 ->references('id_estado')->on('sgd_estados')
    		 ->onDelete('cascade');*/
    	
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
    	Schema::dropIfExists('sgd_notificacion_usuarios');
    }
}
