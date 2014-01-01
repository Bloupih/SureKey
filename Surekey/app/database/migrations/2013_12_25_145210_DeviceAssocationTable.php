<?php

use Illuminate\Database\Migrations\Migration;

class DeviceAssocationTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::Create('devices',function($table){
            $table->increments('id');
            $table->string('device');
            $table->String('password');
            $table->string('description')->nullable();
            $table->integer('userid');
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