<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttendancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('employee_id')->unsigned();
            $table->date('attendance_date');
            $table->time('in_time');
            $table->time('exit_time');
            $table->float('overtime',8,2);
            $table->boolean('shift')->default(false);
            $table->float('measurement_quantity',8,2)->nullable();
            $table->float('total_wage',8,2)->nullable();
            $table->float('overtime_wage',8,2)->nullable();
            $table->float('net_wage',8,2)->nullable();
            $table->integer('company_id')->unsigned()->nullable();
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
        Schema::dropIfExists('attendances');
    }
}
