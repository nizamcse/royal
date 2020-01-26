<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurchaseSalesChalanDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_sales_chalan_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('chalan_id')->unsigned();
            $table->integer('purchase_order_detail_id')->unsigned();
            $table->integer('inventory_item_id')->unsigned();
            $table->integer('received_qty')->nullable();
            $table->float('goods_amount')->nullable();
            $table->integer('company_id')->unsigned()->nullable();
            $table->timestamps();
            $table->foreign('chalan_id')->references('id')->on('sales_chalans');
            $table->foreign('purchase_order_detail_id')->references('id')->on('purchase_order_details');
            $table->foreign('inventory_item_id')->references('id')->on('inventory_items');
            $table->foreign('company_id')->references('id')->on('companies');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('purchase_sales_chalan_details');
    }
}
