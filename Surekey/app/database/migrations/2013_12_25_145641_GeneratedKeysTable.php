<?php

use Illuminate\Database\Migrations\Migration;

class GeneratedKeysTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::Create('keys', function($table){
            $table->increments('id');
            $table->string('content');
            $table->integer('accountid');
            $table->Integer('deviceid');
            $table->integer('status')->default(1);
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
		//
	}

}