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
        Schema::create('book', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('skill');
            $table->string('author');
            $table->string('author_bio');
            $table->string('description');
            $table->float('price');
            $table->float('rating');
            $table->string('img_url');
            $table->string('book_url');
            $table->timestamp('crawled_at');
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
        Schema::drop('book');
    }
}
