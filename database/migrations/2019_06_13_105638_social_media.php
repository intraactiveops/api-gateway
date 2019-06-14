<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SocialMedia extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('social_media', function(Blueprint $table){
        $table->increments('id');
        $table->char('name', 100);
        $table->char('url', 200);
        $table->char('icon_name', 50);
        $table->char('link_code_alias', 20)->comment('username or profile id');
        $table->timestamps();
        $table->softDeletes();
      });
      Schema::table('user_social_media_links', function (Blueprint $table) {
        $table->foreign('social_media_id')->references('id')->on('social_media');
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
