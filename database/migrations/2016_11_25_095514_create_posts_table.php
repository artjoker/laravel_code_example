<?php

  use Illuminate\Support\Facades\Schema;
  use Illuminate\Database\Schema\Blueprint;
  use Illuminate\Database\Migrations\Migration;

  class CreatePostsTable extends Migration
  {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('posts', function (Blueprint $table) {
        $table->increments('id');
        $table->integer('userId')->unsigned();
        $table->string('title');
        $table->text('body');
        $table->timestamps();

        $table
          ->foreign('userId')
          ->references('id')
          ->on('users')
          ->onUpdate('cascade')
          ->onDelete('cascade');
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::drop('posts');
    }
  }
