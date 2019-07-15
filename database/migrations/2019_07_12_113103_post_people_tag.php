<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PostPeopleTag extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('post_user_tags', function(Blueprint $table){
          $table->bigIncrements('id');
          $table->unsignedBigInteger('user_id');
          $table->unsignedBigInteger('post_id');
          $table->timestamps();
          $table->softDeletes();
        });
        Schema::table('post_user_tags', function(Blueprint $table){
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
        Schema::dropIfExists('post_user_tags');
    }
}
