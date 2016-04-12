<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('posts_comments', function (Blueprint $table) {
        $table->unique('_id');
        $table->integer('post_id');
        $table->string('name');
        $table->string('email');
        $table->text('comment');
        $table->boolean('draft');
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
      Schema::drop('posts_comments');
    }
}
