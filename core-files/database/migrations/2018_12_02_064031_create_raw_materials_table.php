<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRawMaterialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('raw_materials', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('unit_id')->unsigned();
            $table->integer('company_id')->unsigned()->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('unit_id')->references("id")->on('units')->onDelete('cascade');
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
        Schema::dropIfExists('raw_materials');
    }
}
