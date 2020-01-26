<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductionMaterialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('production_materials', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('purchase_order_id')->unsigned();
            $table->integer('production_id')->unsigned();
            $table->integer('raw_material_id')->unsigned();
            $table->integer('unit_id')->unsigned();
            $table->integer('inventory_item_id')->unsigned()->nullable();
            $table->integer('purchase_order_detail_id')->unsigned()->nullable();
            $table->float('quantity');
            $table->float('wasted_quantity')->default(0);
            $table->float('used_quantity')->default(0);
            $table->float('price_per_unit');
            $table->float('thickness')->nullable();
            $table->string('size')->nullable();
            $table->integer('company_id')->unsigned()->nullable();
            $table->double('amount');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('purchase_order_id')->references('id')->on('purchase_orders')->onDelete('cascade');
            $table->foreign('raw_material_id')->references('id')->on('raw_materials')->onDelete('cascade');
            $table->foreign('unit_id')->references('id')->on('units')->onDelete('cascade');
            $table->foreign('inventory_item_id')->references('id')->on('inventory_items')->onDelete('cascade');
            $table->foreign('production_id')->references('id')->on('productions')->onDelete('cascade');
            $table->foreign('company_id')->references('id')->on('companies');
            $table->foreign('purchase_order_detail_id')->references('id')->on('purchase_order_details');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('production_materials');
    }
}
