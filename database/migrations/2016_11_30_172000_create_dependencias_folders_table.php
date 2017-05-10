<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDependenciasFoldersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    	Schema::create('sgd_dependencias_folders', function (Blueprint $table) {
    		$table->increments('id_dependen_folder');
    		$table->integer('id_dependencia');
    		$table->integer('id_folder');
    		$table->integer('id_tabla'); 
    		$table->integer('id_usuario'); 
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
    	Schema::dropIfExists('sgd_dependencias_folders');
    }
}
