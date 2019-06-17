<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Borrowings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('borrowings', function(Blueprint $table){
        $table->increments('id');
        $table->unsignedInteger('borrower_id');
        $table->unsignedInteger('borrow_cycle_id');
        $table->double('amount');
        $table->text('note')->nullable();
        $table->timestamp('datetime_paid')->nullable();
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
