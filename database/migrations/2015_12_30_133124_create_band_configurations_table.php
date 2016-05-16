<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBandConfigurationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('band_configurations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('band_id')->unsigned()->nullable();
            $table->integer('buyer_id')->unsigned()->nullable();
            $table->integer('seller_id')->unsigned()->nullable();
        });
        Schema::table('band_configurations', function (Blueprint $table) {
            $table->foreign('band_id')->references('id')->on('bands')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('buyer_id')->references('id')->on('companies')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('seller_id')->references('id')->on('companies')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
