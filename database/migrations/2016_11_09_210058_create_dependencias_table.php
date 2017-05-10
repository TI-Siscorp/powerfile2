<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDependenciasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    	Schema::create('sgd_dependencias', function (Blueprint $table) {
    		$table->increments('id_dependencia');
    		$table->string('descripcion');
    		$table->string('codigo_departamento')->unique();
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
    	Schema::dropIfExists('sgd_dependencias');
    }
}
