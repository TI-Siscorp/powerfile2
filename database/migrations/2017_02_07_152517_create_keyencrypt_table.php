<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKeyencryptTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('sgd_encrypt', function (Blueprint $table) {
			$table->increments('id_encrypt');
			$table->string('valor_key');
			$table->string('key_encrypt');
			$table->integer('id_estado')->unsigned();
			$table->integer('id_usuario')->unsigned();
			$table->integer('tiene_img')->default(0);

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
		Schema::dropIfExists('sgd_encrypt');
	}
}
