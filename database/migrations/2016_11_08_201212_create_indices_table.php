<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIndicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    	Schema::create('sgd_indices', function (Blueprint $table) {
    		$table->increments('id_indice');
    		$table->string('nombre');
    		$table->integer('id_tipo')->unsigned();
    		$table->text('descripcion');   		
    		$table->integer('id_estado')->unsigned();
    		$table->integer('orden');
    		$table->text('delistakey')->nullable();	
    		$table->text('delistavalor')->nullable();
    		
    		/*$table->foreign('id_tipo')
    		->references('id_tipo')->on('sgd_tipoindices')
    		->onDelete('cascade');
    		$table->foreign('id_estado')
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
    	Schema::dropIfExists('sgd_indices');
    }
}
