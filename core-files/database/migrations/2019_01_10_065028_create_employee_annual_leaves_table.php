<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeeAnnualLeavesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_annual_leaves', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('employee_id')->iunsigned();
            $table->integer('leave_type_id')->iunsigned();
            $table->integer('year');
            $table->integer('taken_leave_days')->default(0);
            $table->integer('company_id')->unsigned()->nullable();
            $table->timestamps();
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
        Schema::dropIfExists('employee_annual_leaves');
    }
}
