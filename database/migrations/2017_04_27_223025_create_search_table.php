<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSearchTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    	Schema::create('sgd_search', function (Blueprint $table) {
    		$table->increments('id_search');
    		$table->integer('id_documento')->unsigned();
    		$table->integer('id_expediente')->unsigned();
    		$table->text('id_tipodocumental');
    		$table->integer('id_node')->unsigned();
    		$table->integer('id_tabla')->unsigned();
    		$table->text('id_indices')->nullable();	
    		$table->text('nombre')->nullable();
    		$table->text('search')->nullable();	
    		$table->text('usuarios')->nullable();
    		$table->integer('id_estado')->unsigned();
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
    	Schema::dropIfExists('sgd_search');
    }
}
