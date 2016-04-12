<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
      Schema::table('posts', function (Blueprint $table) {
          $table->dateTime('published_at');
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
      $table->dropColumn('published_at');
    }
}
