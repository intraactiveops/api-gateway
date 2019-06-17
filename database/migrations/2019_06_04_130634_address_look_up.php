<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddressLookUp extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('countries', function(Blueprint $table){
          $table->increments('id');
          $table->char('name', 50);
          $table->char('code', 2);
          $table->timestamps();
          $table->softDeletes();
        });
        Schema::create('regions', function(Blueprint $table){
          $table->increments('id');
          $table->unsignedInteger('country_id');
          $table->char('name', 100);
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
        //
    }
}
