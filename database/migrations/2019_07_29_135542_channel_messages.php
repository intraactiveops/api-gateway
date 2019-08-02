<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChannelMessages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('channel_messages', function(Blueprint $table){
        $table->bigIncrements('id');
        $table->unsignedBigInteger('channel_id');
        $table->unsignedBigInteger('user_id');
        $table->tinyInteger('type')->comment('1 - simple message, 2 - thread message, 3 - email');
        $table->timestamps();
        $table->softDeletes();
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::dropIfExists('channel_messages');
    }
}
