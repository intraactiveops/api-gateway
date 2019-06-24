<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UserAwards extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('user_awards', function(Blueprint $table){
        $table->increments('id');
        $table->unsignedBigInteger('user_id');
        $table->date('date');
        $table->text('description');
        $table->text('host');
        $table->timestamps();
        $table->softDeletes();
      });
      Schema::table('user_awards', function (Blueprint $table) {
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
        Schema::dropIfExists('user_awards');
    }
}
