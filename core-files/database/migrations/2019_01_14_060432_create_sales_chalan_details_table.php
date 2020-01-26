<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalesChalanDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_chalan_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('chalan_id')->unsigned();
            $table->integer('sales_order_details_id')->unsigned();
            $table->integer('good_id')->unsigned();
            $table->integer('received_qty')->nullable();
            $table->float('goods_amount')->nullable();
            $table->integer('company_id')->unsigned()->nullable();
            $table->timestamps();
            $table->foreign('chalan_id')->references('id')->on('sales_chalans');
            $table->foreign('sales_order_details_id')->references('id')->on('sales_order_details');
            $table->foreign('good_id')->references('id')->on('goods');
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
        Schema::dropIfExists('sales_chalan_details');
    }
}
