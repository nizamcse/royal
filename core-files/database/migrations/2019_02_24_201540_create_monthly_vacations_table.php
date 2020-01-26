<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMonthlyVacationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('monthly_vacations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('vacation_id')->unsigned();
            $table->integer('company_id')->unsigned();
            $table->tinyInteger('month');
            $table->integer('year');
            $table->tinyInteger('days');
            $table->timestamps();
            $table->foreign('vacation_id')->references('id')->on('vacations')->onDelete('cascade');
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('monthly_vacations');
    }
}
