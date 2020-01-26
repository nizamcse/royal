<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productions', function (Blueprint $table) {
            $table->increments('id');
            $table->dateTime('start_at')->nullable();
            $table->dateTime('end_at')->nullable();
            $table->boolean('good_produced')->default(true);
            $table->text('comment')->nullable();
            $table->integer('total_labour')->nullable();
            $table->double('total_labour_cost')->nullable();
            $table->double('utility_cost')->nullable();
            $table->double('other_cost')->nullable();
            $table->double('total_production_cost')->nullable();
            $table->integer('company_id')->unsigned()->nullable();
            $table->float('production_hour',10,2)->nullable();
            $table->timestamps();
            $table->softDeletes();
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
        Schema::dropIfExists('productions');
    }
}
