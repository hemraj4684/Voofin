<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentInstructionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_instructions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('invoice_id')->unsigned()->nullable();
            $table->integer('buyer_id')->unsigned()->nullable();
            $table->integer('seller_id')->unsigned()->nullable();
            $table->float('amount');
            $table->tinyInteger('status');
            $table->timestamps();
        });
        Schema::table('payment_instructions', function (Blueprint $table) {
            $table->foreign('invoice_id')->references('id')->on('invoices')->onUpdate('cascade')->onDelete('cascade');
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
