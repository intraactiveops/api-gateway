<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UserContactList extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('user_contact_lists', function(Blueprint $table){
        $table->increments('id');
        $table->unsignedBigInteger('user_id');
        $table->unsignedBigInteger('contact_user_id');
        $table->timestamps();
        $table->softDeletes();
      });
      Schema::table('user_contact_lists', function (Blueprint $table) {
        $table->foreign('user_id')->references('id')->on('users');
        $table->foreign('contact_user_id')->references('id')->on('users');
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
