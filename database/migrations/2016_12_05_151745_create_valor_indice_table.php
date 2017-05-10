<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateValorIndiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
	    {
	    	Schema::create('sgd_valorindice', function (Blueprint $table) {
	    		$table->increments('id_valorindice');
	    		$table->integer('id_documento')->unsigned();
	    		$table->integer('id_indice')->unsigned();
	    		$table->string('valor');    		
	    		$table->integer('id_estado')->unsigned();
	    		 
	    		/*$table->foreign('id_documento')
	    		->references('id_documento')->on('sgd_documentos')
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
	    	Schema::dropIfExists('sgd_valorindice');
	    }
}
