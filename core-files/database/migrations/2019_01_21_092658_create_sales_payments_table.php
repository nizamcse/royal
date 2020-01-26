<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalesPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_payments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('sales_order_id')->unsigned();
            $table->integer('payment_type_id')->unsigned();
            $table->double('amount')->default(0);
            $table->date('payment_date');
            $table->string('attachment')->nullable();
            $table->integer('company_id')->unsigned()->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('sales_order_id')->references('id')->on('sales_orders')->onDelete('cascade');
            $table->foreign('payment_type_id')->references('id')->on('payment_types')->onDelete('cascade');
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
        Schema::dropIfExists('sales_payments');
    }
}
