<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFoldersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    	
    	
    	
    	Schema::create('sgd_folders', function (Blueprint $table) {
    		$table->increments('id');
    		$table->string('nombre');
    		$table->string('text');
    		$table->string('parent_id');
    		$table->integer('id_tabla')->unsigned();
    		$table->integer('id_estado')->unsigned();
    	
    		/*$table->foreign('id_tabla')
    		->references('id_tabla')->on('sgd_tablas')
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
    	Schema::dropIfExists('sgd_folders');
    }
}
