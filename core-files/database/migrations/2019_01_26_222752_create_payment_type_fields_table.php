<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentTypeFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_type_fields', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('payment_type_id')->unsigned()->nullable();
            $table->integer('company_id')->unsigned()->nullable();
            $table->boolean('date_type')->default(false);
            $table->timestamps();
            $table->foreign('payment_type_id')->references('id')->on('payment_types');
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
        Schema::dropIfExists('payment_type_fields');
    }
}
