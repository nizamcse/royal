<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddProductionIdToPurchaseOrderDetailLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('purchase_order_detail_logs', function (Blueprint $table) {
            $table->integer('production_id')->unsigned()->nullable();
            $table->foreign('production_id')->references('id')->on('productions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('purchase_order_detail_logs', function (Blueprint $table) {
            $table->dropColumn('production_id');
        });
    }
}
