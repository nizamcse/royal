<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ReviseEmployeeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->boolean('shift')->default(false);
            $table->tinyInteger('salary_type')->default(1);
            $table->time('in_time')->nullable();
            $table->time('exit_time')->nullable();
            $table->float('minimum_working_hour',5,2)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->dropColumn('shift','salary_type','in_time','exit_time','minimum_working_hour');
        });
    }
}
