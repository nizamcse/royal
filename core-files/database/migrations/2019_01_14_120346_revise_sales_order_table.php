<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ReviseSalesOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sales_orders', function (Blueprint $table) {
            $table->double('total_amount',12,2)->default(0);
            $table->double('payable_amount',12,2)->default(0);
            $table->double('paid_amount',12,2)->default(0);
            $table->double('due_amount',12,2)->default(0);
            $table->double('return_product_amount',12,2)->default(0);
            $table->double('other_charge')->nullable()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sales_orders', function (Blueprint $table) {
            $table->dropColumn('total_amount','paid_amount','due_amount','return_product_amount');
        });
    }
}
