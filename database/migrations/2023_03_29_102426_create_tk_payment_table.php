<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTkPaymentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tk_payment', function (Blueprint $table) {
            $table->id();
            $table->integer('CustId')->unsigned();
            $table->integer('InsertedByUserId')->unsigned();
            $table->text('PaymentFromDate');
            $table->text('PaymentToDate');
            $table->timestamps();
            $table->foreign('CustId')->references('cust_id')->on('tk_customername')->onDelete('cascade');
            $table->foreign('InsertedByUserId')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tk_payment');
    }
}
