<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductionGoodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('production_goods', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('produced_good_id')->unsigned();
            $table->integer('good_id')->unsigned();
            $table->float('quantity')->default(0);
            $table->integer('company_id')->unsigned()->nullable();
            $table->timestamps();
            $table->foreign('produced_good_id')->references('id')->on('produced_goods');
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
        Schema::dropIfExists('production_goods');
    }
}
