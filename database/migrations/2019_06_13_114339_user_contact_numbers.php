<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UserContactNumbers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('user_contact_numbers', function(Blueprint $table){
        $table->increments('id');
        $table->unsignedBigInteger('user_id');
        $table->char('office', 20)->nullable();
        $table->char('direct', 20)->nullable();
        $table->char('cell', 20)->nullable();
        $table->char('fax', 20)->nullable();
        $table->timestamps();
        $table->softDeletes();
      });
      Schema::table('user_contact_numbers', function (Blueprint $table) {
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
        Schema::dropIfExists('user_contact_numbers');
    }
}
