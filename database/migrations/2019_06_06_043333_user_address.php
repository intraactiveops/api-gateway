<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UserAddress extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('user_addresses', function(Blueprint $table){
        $table->increments('id');
        $table->tinyInteger('type')->comment('1 - permanent, 2 - current, 3 and up - others');
        $table->unsignedInteger('user_id');
        $table->unsignedInteger('region_id');
        $table->text('address');
        $table->char('zip_code', 10);
        $table->char('city', 100);
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
