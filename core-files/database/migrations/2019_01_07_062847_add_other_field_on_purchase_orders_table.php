<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOtherFieldOnPurchaseOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('purchase_orders', function (Blueprint $table) {
            $table->double('amount')->default(0);
            $table->double('due_amount')->default(0);
            $table->double('paid_amount')->default(0);
            $table->tinyInteger('status')->default(0)->comment('0:draft, 1:saved');
            $table->unsignedInteger('created_by')->default('null');
            $table->unsignedInteger('saved_by')->default('null');
            $table->unsignedInteger('updated_by')->default('null');

            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('saved_by')->references('id')->on('users');
            $table->foreign('updated_by')->references('id')->on('users');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('purchase_orders', function (Blueprint $table) {
            $table->dropColumn('amount','due_amount','paid_amount');
            $table->dropForeign('purchase_orders_created_by_foreign');
            $table->dropColumn('created_by');
            $table->dropForeign('purchase_orders_saved_by_foreign');
            $table->dropColumn('saved_by');
            $table->dropForeign('purchase_orders_updated_by_foreign');
            $table->dropColumn('updated_by');

        });
    }
}
