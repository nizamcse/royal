<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddProductionIdToProducedGoodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('produced_goods', function (Blueprint $table) {
            $table->integer('production_id')->unsigned();
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
        Schema::table('produced_goods', function (Blueprint $table) {
            $table->dropColumn('production_id');
        });
    }
}
