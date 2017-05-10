<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBusquedaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    	Schema::create('sgd_busquedas', function (Blueprint $table) {
    		$table->increments('id_busqueda');
    		$table->integer('id_usuario')->unsigned();
    		$table->text('busqueda'); 
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
    	Schema::dropIfExists('sgd_busquedas');
    }
}
