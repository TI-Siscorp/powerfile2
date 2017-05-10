<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAuditoriabuscarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    	Schema::create('sgd_auditoria_zip', function (Blueprint $table) {
    		$table->increments('sgd_auditoria_zip');
    		$table->integer('id_usuario')->unsigned();
    		$table->string('busqueda');
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
    	Schema::dropIfExists('sgd_auditoria_zip');
    }
}
