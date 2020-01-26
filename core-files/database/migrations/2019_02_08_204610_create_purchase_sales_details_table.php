<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurchaseSalesDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_sales_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('sales_order_id')->unsigned();
            $table->integer('inventory_item_id')->unsigned();
            $table->integer('po_detail_id')->unsigned();
            $table->integer('unit_id')->unsigned();
            $table->float('unit_price')->default(0);
            $table->float('base_price')->default(0);
            $table->float('quantity')->default(0);
            $table->float('delivered_quantity')->default(0);
            $table->float('remaining_quantity')->default(0);
            $table->float('returned_quantity')->default(0);
            $table->float('discount')->default(0);
            $table->double('sub_total',10,2)->default(0);
            $table->integer('company_id')->unsigned()->nullable();
            $table->timestamps();
            $table->foreign('sales_order_id')->references('id')->on('sales_orders');
            $table->foreign('inventory_item_id')->references('id')->on('inventory_items');
            $table->foreign('unit_id')->references('id')->on('units');
            $table->foreign('company_id')->references('id')->on('companies');
            $table->foreign('po_detail_id')->references('id')->on('purchase_order_details');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('purchase_sales_details');
    }
}
