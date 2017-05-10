<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocumentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    	Schema::create('sgd_documentos', function (Blueprint $table) {
    		$table->increments('id_documento');
    		$table->integer('id_expediente')->unsigned();
    		$table->integer('id_tipodocumental')->unsigned();
    		$table->integer('id_usuario')->unsigned();
    		$table->integer('id_tabla')->unsigned();
    		$table->integer('id_folder')->unsigned();
    		$table->integer('orden');
    		$table->integer('id_estado')->unsigned();
    		 
    		/*$table->foreign('id_expediente')
    		->references('id_expediente')->on('sgd_expedientes')
    		->onDelete('cascade');
    		
    		$table->foreign('id_tipodocumental')
    		->references('id_tipodoc')->on('sgd_tipodocumentales')
    		->onDelete('cascade');
    		
    		$table->foreign('id_tabla')
    		->references('id_tabla')->on('sgd_tablas')
    		->onDelete('cascade');
    		
    		$table->foreign('id_folder')
    		->references('id')->on('sgd_folders')
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
    	Schema::dropIfExists('sgd_documentos');
    }
}
