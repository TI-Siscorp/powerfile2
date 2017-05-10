<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTipodocIndicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    	Schema::create('sgd_tipodoc_indices', function (Blueprint $table) {
    		$table->increments('id_tipodoc_indice');
    		$table->integer('id_tipodoc');
    		$table->integer('id_indice');
    		$table->integer('id_folder');
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
    	Schema::dropIfExists('sgd_tipodoc_indices');
    }
}
