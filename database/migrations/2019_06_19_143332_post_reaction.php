<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PostReaction extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('post_reactions', function(Blueprint $table){
        $table->increments('id');
        $table->unsignedBigInteger('post_id');
        $table->unsignedBigInteger('user_id')->comment('the user who reacted');
        $table->tinyInteger('reaction')->comment('1 - like, 2 - haha, 3 - love, 4 - wow, 5 - sad');
        $table->timestamps();
        $table->softDeletes();
      });
      Schema::table('post_reactions', function(Blueprint $table){
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
      Schema::dropIfExists('post_reactions');
    }
}
