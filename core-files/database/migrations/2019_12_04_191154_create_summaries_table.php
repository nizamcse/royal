<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSummariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('summaries', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('summary_type_id')->unsigned();
            $table->date('summary_data');
            $table->double('receive')->default(0);
            $table->double('payment')->default(0);
            $table->double('balance')->default(0);
            $table->text('comment')->default(null);
            $table->integer('company_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('summary_type_id')->references('id')->on('summary_types');
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
        Schema::dropIfExists('summaries');
    }
}
