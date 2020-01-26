<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalesChalansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_chalans', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('sales_order_id')->unsigned();
            $table->date('chalan_date')->nullable();
            $table->string('chalan_no')->unique()->nullable();
            $table->string('chalan_no_manual')->unique()->nullable();
            $table->integer('company_id')->unsigned()->nullable();
            $table->timestamps();
            $table->foreign('sales_order_id')->references('id')->on('sales_orders');
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
        Schema::dropIfExists('sales_chalans');
    }
}
