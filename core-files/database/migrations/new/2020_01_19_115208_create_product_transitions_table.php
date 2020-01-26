<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductTransitionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_transitions', function (Blueprint $table) {

            $table->increments('id');
            $table->integer('order_id')->unsigned();
            $table->integer('parent_id')->unsigned()->nullable();
            $table->integer('raw_material_id')->unsigned();
            $table->integer('inventory_item_id')->unsigned()->nullable();
            $table->integer('unit_id')->unsigned();
            $table->float('quantity');
            $table->float('d_u_quantity')->default(0);
            $table->float('r_w_quantity')->default(0);
            $table->float('discount')->default(0);
            $table->float('price_per_unit')->default(0);
            $table->float('base_price')->default(0);
            $table->double('amount');
            $table->integer('company_id')->unsigned()->nullable();
            $table->tinyInteger('material_type')->default(1)->comment("1: Raw Material, 2: Other Material");
            $table->string('transition_type',6);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_transitions');
    }
}
