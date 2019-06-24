<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UserMemberships extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('user_organizations', function(Blueprint $table){
        $table->increments('id');
        $table->unsignedBigInteger('user_id');
        $table->smallInteger('year_started');
        $table->smallInteger('year_ended')->nullable();
        $table->text('name');
        $table->text('address');
        $table->timestamps();
        $table->softDeletes();
      });
      Schema::table('user_organizations', function (Blueprint $table) {
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
        Schema::dropIfExists('user_organizations');
    }
}
