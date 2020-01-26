<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductionProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('production_products', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('good_id')->unsigned();
            $table->float('quantity')->default(0);
            $table->timestamps();
            $table->integer('company_id')->unsigned()->nullable();
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
        Schema::dropIfExists('production_products');
    }
}
