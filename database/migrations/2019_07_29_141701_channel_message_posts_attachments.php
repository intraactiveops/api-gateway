<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChannelMessagePostsAttachments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('channel_message_post_attachments', function(Blueprint $table){
        $table->bigIncrements('id');
        $table->unsignedBigInteger('channel_message_post_id');
        $table->char('type', 20)->nullable()->comment('file type of attachment');
        $table->text('name')->comment('real file name of the attachment');
        $table->text('file_name')->nullable();
        $table->text('preview_file_name')->nullable()->comment('applicable to uploaded photos only');
        $table->double('size', 20, 3)->comment('size in kb');
        $table->timestamps();
        $table->softDeletes();
      });
      Schema::table('channel_message_post_attachments', function(Blueprint $table){
        $table->foreign('channel_message_post_id')->references('id')->on('posts');
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::dropIfExists('channel_message_post_attachments');
    }
}
