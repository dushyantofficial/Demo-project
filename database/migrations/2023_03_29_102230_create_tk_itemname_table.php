<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTkItemnameTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tk_itemname', function (Blueprint $table) {
            $table->increments('item_id');
            $table->integer('insertedByUserId')->unsigned();
            $table->string('item_name');
            $table->timestamps();
            $table->foreign('insertedByUserId')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tk_itemname');
    }
}
