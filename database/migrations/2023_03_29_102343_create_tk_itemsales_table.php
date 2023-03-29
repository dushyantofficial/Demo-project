<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTkItemsalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tk_itemsales', function (Blueprint $table) {
            $table->increments('ItemSalesId');
            $table->date('payment_from_date')->nullable();
            $table->date('payment_to_date')->nullable();
            $table->string('from_morning_evening')->nullable();
            $table->string('to_morning_evening')->nullable();
            $table->date('deduct_from_date')->nullable();
            $table->date('deduct_to_date')->nullable();
            $table->date('entry_date')->nullable();
            $table->string('deduct_morning_evening')->nullable();
            $table->double('payment')->nullable();
            $table->double('deduct_payment')->nullable();
            $table->double('total')->nullable();
            $table->double('total_quantity')->nullable();
            $table->integer('CustId')->unsigned();
            $table->integer('ItemId')->unsigned();
            $table->double('ItemQty');
            $table->string('CustPhoto');
            $table->integer('InsertedByUserId')->unsigned();
            $table->timestamps();
            $table->foreign('CustId')->references('cust_id')->on('tk_customername')->onDelete('cascade');
            $table->foreign('InsertedByUserId')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('ItemId')->references('purchase_id')->on('tk_itempurchase')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tk_itemsales');
    }
}
