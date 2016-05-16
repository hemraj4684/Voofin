<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePoItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('po_items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('purchase_order_id')->unsigned()->nullable();
            $table->string('name');
            $table->text('description');
            $table->string('code');
            $table->double('unit_price', 20,2);
            $table->integer('quantity');
            $table->double('total', 20,2);
            $table->timestamps();
        });

         Schema::table('po_items', function (Blueprint $table) {
            $table->foreign('purchase_order_id')->references('id')->on('purchase_orders')->onUpdate('cascade')->onDelete('cascade');
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
