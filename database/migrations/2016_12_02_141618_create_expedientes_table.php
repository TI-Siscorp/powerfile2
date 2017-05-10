<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExpedientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    	Schema::create('sgd_expedientes', function (Blueprint $table) {
    		$table->increments('id_expediente');
    		$table->integer('id_usuario');
    		$table->integer('id_tabla')->unsigned();
    		$table->integer('spider');
    		$table->integer('id_central')->unsigned();
    		$table->string('nombre');
    		$table->integer('id_estado')->unsigned();
    		 
    		/*$table->foreign('id_estado')
    		->references('id_estado')->on('sgd_estados')
    		->onDelete('cascade');
    		
    		$table->foreign('id_tabla')
    		->references('id_tabla')->on('sgd_tablas')
    		->onDelete('cascade');
    		
    		$table->foreign('id_central')
    		->references('id_central')->on('sgd_central')
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
    	Schema::dropIfExists('sgd_expedientes');
    }
}