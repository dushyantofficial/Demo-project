<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTkItempurchaseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tk_itempurchase', function (Blueprint $table) {
            $table->increments('purchase_id');
            $table->integer('item_name_id')->unsigned();
            $table->double('item_qty');
            $table->integer('insertedByUserId')->unsigned();
            $table->double('deduct_qty');
            $table->double('purchase_rate');
            $table->double('sales_rate');
            $table->date('purchase_date')->nullable();
            $table->timestamps();
            $table->foreign('insertedByUserId')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('item_name_id')->references('item_id')->on('tk_itemname')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tk_itempurchase');
    }
}
