<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePoemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('poems', function (Blueprint $table) {
            $table->increments('id');
			$table->string('name');
            $table->integer('author');
            $table->longtext('description');
            $table->longtext('content');
            $table->integer('poster');
            $table->biginteger('comments');
            $table->biginteger('poem_views');   
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
        Schema::drop('poems');
    }
}
