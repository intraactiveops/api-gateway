<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PostComment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('post_comments', function(Blueprint $table){
        $table->bigIncrements('id');
        $table->unsignedBigInteger('post_id');
        $table->unsignedBigInteger('post_comment_id')->nullable()->comment('comment reply');
        $table->unsignedBigInteger('user_id')->comment('the user who commented');
        $table->text('comment');
        $table->timestamps();
        $table->softDeletes();
      });
      Schema::table('post_comments', function(Blueprint $table){
        $table->foreign('user_id')->references('id')->on('users');
        $table->foreign('post_id')->references('id')->on('posts');
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::dropIfExists('post_comments');
    }
}
