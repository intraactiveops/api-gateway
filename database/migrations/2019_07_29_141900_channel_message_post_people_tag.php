<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChannelMessagePostPeopleTag extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('channel_message_post_user_tags', function(Blueprint $table){
        $table->bigIncrements('id');
        $table->unsignedBigInteger('user_id');
        $table->unsignedBigInteger('channel_message_post_id');
        $table->timestamps();
        $table->softDeletes();
      });
      Schema::table('channel_message_post_user_tags', function(Blueprint $table){
        $table->foreign('user_id')->references('id')->on('users');
        $table->foreign('channel_message_post_id')->references('id')->on('channel_message_posts');
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::dropIfExists('channel_message_post_user_tags');
    }
}
