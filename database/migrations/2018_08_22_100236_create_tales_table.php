<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tales', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('category');
            $table->string('name');
            $table->integer('author');
            $table->longtext('description');
            $table->longtext('content');
            $table->integer('poster');
			$table->biginteger('tale_views');
            $table->biginteger('comments');        
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
        Schema::drop('tales');
    }
}
