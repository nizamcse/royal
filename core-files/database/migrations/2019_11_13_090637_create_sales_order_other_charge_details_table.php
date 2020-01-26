<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalesOrderOtherChargeDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_order_other_charge_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('sales_order_id');
            $table->string('charge_description')->nullable();
            $table->double('charge_amount')->nullable()->default(0);
            $table->unsignedInteger('company_id')->nullable();
            $table->timestamps();
            $table->foreign('sales_order_id')->references('id')->on('sales_orders')->onDelete('cascade');
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
        Schema::table('sales_order_other_charge_details', function (Blueprint $table) {
            $table->dropForeign('sales_order_other_charge_details_sales_order_id_foreign');
            $table->dropForeign('sales_order_other_charge_details_company_id_foreign');
        });
        Schema::dropIfExists('sales_order_other_charge_details');
    }
}
