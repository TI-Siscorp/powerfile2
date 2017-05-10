<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSetupbodegaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    	Schema::create('sgd_setupbodega', function (Blueprint $table) {
    		$table->increments('id_setup');
    		$table->text('modobodega');
    		$table->text('ftp_server');
    		$table->text('ftp_user');
    		$table->text('ftp_pass');
    		$table->text('ftp_port'); 
    		$table->integer('estatus')->unsigned();
    		
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
    	Schema::dropIfExists('sgd_setupbodega');
    }
}
