<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurchaseOrderDetailLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_order_detail_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('log_no')->nullable();
            $table->integer('purchase_order_id')->unsigned();
            $table->float('height');
            $table->float('radius');
            $table->float('quantity');
            $table->string('grade',50);
            $table->float('price_per_unit');
            $table->float('total_price');
            $table->float('new_height')->nullable();
            $table->float('new_radius')->nullable();
            $table->float('new_quantity')->nullable();
            $table->float('wastage_quantity')->nullable();
            $table->float('wastage_quantity_in_percent')->nullable();
            $table->float('wastage_total_price')->nullable();
            $table->integer('company_id')->unsigned()->nullable();
            $table->integer('category_id')->unsigned()->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('purchase_order_id')->references('id')->on('purchase_orders')->onDelete('cascade');
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('purchase_order_detail_logs');
    }
}
