<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->integer('skill');
            $table->string('author');
            $table->string('author_bio', 5000);
            $table->string('description', 5000);
            $table->float('price');
            $table->float('rating');
            $table->string('img_url');
            $table->string('book_url');
            $table->timestamps();

            $table->foreign('skill')->references('id')->on('skills');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('books');
    }
}
