<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProducedGoodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produced_goods', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('good_id')->unsigned();
            $table->float('produced_quantity')->default(0);
            $table->float('released_quantity')->default(0);
            $table->integer('company_id')->unsigned()->nullable();
            $table->timestamps();
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
        Schema::dropIfExists('produced_goods');
    }
}
