<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompanyTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('from')->unsigned();
            $table->integer('to')->unsigned();
            $table->integer('journal_entry_id_from')->unsigned()->nullable();
            $table->integer('journal_entry_id_to')->unsigned()->nullable();
            $table->boolean('status')->default(false);
            $table->double('amount');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('from')->references('id')->on('companies')->onDelete('cascade');
            $table->foreign('to')->references('id')->on('companies')->onDelete('cascade');
            $table->foreign('journal_entry_id_from')->references('id')->on('journal_entries')->onDelete('cascade');
            $table->foreign('journal_entry_id_to')->references('id')->on('journal_entries')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('company_transactions');
    }
}
