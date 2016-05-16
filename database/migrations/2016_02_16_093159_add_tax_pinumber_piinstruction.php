<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTaxPinumberPiinstruction extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payment_instructions', function (Blueprint $table) {
            $table->string('tax_amount');
            $table->string('net_amount');
            $table->string('pi_number');
            //$table->string('pi_number')->unique();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('payment_instructions', function(Blueprint $table) {
            $table->dropColumn('tax_amount');
            $table->dropColumn('net_amount');
            $table->dropColumn('pi_number');
        });
    }
}
