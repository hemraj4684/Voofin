<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatDiscountingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('discountings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('uuid')->unique();
            $table->integer('pi_id')->unsigned()->nullable();
            $table->double('remittence_amount',15,2);
            $table->string('interest_percentage',45);
            $table->double('expected_interest',15,2);
            $table->double('other_charges',15,2);
            $table->date('maturity_date');
            $table->timestamps();
        });

       Schema::table('discountings', function (Blueprint $table) {
           $table->foreign('pi_id')->references('id')->on('payment_instructions')->onUpdate('cascade')->onDelete('cascade');
       });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
    }
}
