<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurchasePaymentFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_payment_fields', function (Blueprint $table) {
            $table->increments('id');
            $table->string('field_value');
            $table->integer('purchase_payment_id')->unsigned()->nullable();
            $table->integer('payment_type_field_id')->unsigned()->nullable();
            $table->integer('company_id')->unsigned()->nullable();
            $table->timestamps();
            $table->foreign('payment_type_field_id')->references('id')->on('payment_type_fields');
            $table->foreign('purchase_payment_id')->references('id')->on('purchase_payments');
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
        Schema::dropIfExists('purchase_payment_fields');
    }
}
