<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('designation_id')->unsigned()->nullable();
            $table->string('present_address')->nullable();
            $table->string('permanent_address')->nullable();
            $table->string('nid')->nullable();
            $table->string('photo')->nullable();
            $table->string('contact_no')->nullable();
            $table->string('email')->nullable();
            $table->boolean('status')->default(true);
            $table->integer('company_id')->unsigned()->nullable();
            $table->timestamps();
            $table->foreign('designation_id')->references('id')->on('designations');
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
        Schema::dropIfExists('employees');
    }
}
