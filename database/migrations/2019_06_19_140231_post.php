<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Post extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('posts', function(Blueprint $table){
        $table->bigIncrements('id');
        $table->char('title', 200)->nullable();
        $table->text('text')->nullable();;
        $table->text('posted_from_address')->nullable();
        $table->boolean('is_complete')->default(false)->comment('indicator if the attachments are uploaded. If none, then the value is true');
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
        Schema::dropIfExists('posts');
    }
}
