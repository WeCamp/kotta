<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Conversions extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('conversions', function($table)
        {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->string('file');
            $table->string('fileName');
            $table->integer('track');
            $table->string('trackName');
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
		Schema::drop('conversions');
	}

}
