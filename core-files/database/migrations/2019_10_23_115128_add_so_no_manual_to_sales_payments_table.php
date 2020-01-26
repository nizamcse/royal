<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSoNoManualToSalesPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sales_payments', function (Blueprint $table) {
            $table->string('so_no_manual')->nullable()->after('sales_order_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sales_payments', function (Blueprint $table) {
            $table->dropColumn('so_no_manual');
        });
    }
}
