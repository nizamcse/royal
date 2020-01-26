<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExpensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expenses', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('expense_head_id')->unsigned();
            $table->double('amount')->default(0);
            $table->string('comment')->nullable();
            $table->date('expense_date');
            $table->integer('company_id')->unsigned()->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('expense_head_id')->references('id')->on('expense_heads');
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
        Schema::dropIfExists('expenses');
    }
}
