<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurchaseOrderDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_order_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('purchase_order_id')->unsigned();
            $table->integer('raw_material_id')->unsigned();
            $table->integer('inventory_item_id')->unsigned()->nullable();
            $table->integer('unit_id')->unsigned();
            $table->float('quantity');
            $table->float('returned_quantity')->default(0);
            $table->float('used_quantity')->default(0);
            $table->float('wasted_quantity')->default(0);
            $table->float('sold_quantity')->default(0);
            $table->float('remaining_quantity')->default(0);
            $table->float('price_per_unit');
            $table->double('amount');
            $table->integer('company_id')->unsigned()->nullable();
            $table->tinyInteger('material_type')->default(1)->comment("1: Raw Material, 2: Other Material");
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('purchase_order_id')->references('id')->on('purchase_orders')->onDelete('cascade');
            $table->foreign('raw_material_id')->references('id')->on('raw_materials')->onDelete('cascade');
            $table->foreign('unit_id')->references('id')->on('units')->onDelete('cascade');
            $table->foreign('company_id')->references('id')->on('companies');
            $table->foreign('inventory_item_id')->references('id')->on('inventory_items');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('purchase_order_details');
    }
}
