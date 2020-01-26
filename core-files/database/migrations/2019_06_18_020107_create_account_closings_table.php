<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountClosingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
//    public function up()
//    {
//        Schema::create('account_closings', function (Blueprint $table) {
//            $table->increments('id');
//            $table->integer('closing_start_year');
//            $table->integer('closing_end_year');
//            $table->date('closing_start_from');
//            $table->date('closing_ends_at');
//            $table->integer('created_by')->unsigned();
//            $table->integer('company_id')->unsigned();
//            $table->timestamps();
//            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
//            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
//        });
//    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
//    public function down()
//    {
//        Schema::dropIfExists('account_closings');
//    }
}
