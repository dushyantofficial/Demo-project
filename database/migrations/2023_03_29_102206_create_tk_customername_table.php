<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTkCustomernameTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tk_customername', function (Blueprint $table) {
            $table->increments('cust_id');
            $table->integer('user_id')->nullable();
            $table->string('cust_name')->nullable();
            $table->string('cust_code')->nullable();
            $table->integer('insertedByUserId')->unsigned();
            $table->string('bank_name');
            $table->bigInteger('account_number')->unique();
            $table->string('ifsc_code');
            $table->double('final_amount');
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
        Schema::dropIfExists('tk_customername');
    }
}
