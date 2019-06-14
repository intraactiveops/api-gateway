<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UserSocialMediaLinks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('user_social_media_links', function(Blueprint $table){
        $table->increments('id');
        $table->unsignedBigInteger('user_id');
        $table->unsignedInteger('social_media_id');
        $table->char('link_code', 100)->comment('username or profile id');
        $table->timestamps();
        $table->softDeletes();
      });
      Schema::table('user_social_media_links', function (Blueprint $table) {
        $table->foreign('user_id')->references('id')->on('users');
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
