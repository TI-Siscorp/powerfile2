<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocumImagenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    	Schema::create('sgd_imagen_documento', function (Blueprint $table) {
    		$table->increments('id_imagendocum');
    		$table->integer('id_documento')->unsigned();
    		$table->string('nombre');
    		$table->string('extension');
    		$table->integer('id_bodega')->unsigned();
    		$table->integer('orden')->default(0);
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
    	Schema::dropIfExists('sgd_documimagen');
    }
}
