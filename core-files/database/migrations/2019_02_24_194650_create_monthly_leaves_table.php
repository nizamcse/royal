<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMonthlyLeavesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('monthly_leaves', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('leave_id')->unsigned();
            $table->integer('company_id')->unsigned();
            $table->tinyInteger('month');
            $table->integer('year');
            $table->integer('days');
            $table->timestamps();
            $table->foreign('leave_id')->references('id')->on('leaves')->onDelete('cascade');
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('monthly_leaves');
    }
}
