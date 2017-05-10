<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAuditoriazipTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    	Schema::create('sgd_auditoria_zip', function (Blueprint $table) {
    		$table->increments('id_auditoria');
    		$table->integer('id_usuario')->unsigned();
    		$table->text('zip');
    		$table->integer('archivos');
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
    	Schema::dropIfExists('sgd_auditoria_zip');
    }
}
