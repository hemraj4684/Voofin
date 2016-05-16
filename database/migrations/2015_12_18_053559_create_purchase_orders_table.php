<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurchaseOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_orders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('uuid')->unique();
            $table->string('purchase_order_number')->unique();
            $table->integer('buyer_id')->unsigned()->nullable();
            $table->integer('seller_id')->unsigned()->nullable();
            $table->double('amount', 20,2);
            $table->double('tax', 20,2);
            $table->double('discount', 20,2);
            $table->double('final_amount', 20,2);
            $table->tinyInteger('status');
            $table->timestamps();
        });
        Schema::table('purchase_orders', function (Blueprint $table) {
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
