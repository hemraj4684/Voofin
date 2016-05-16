<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PaymentInstructionEdit extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payment_instructions', function (Blueprint $table) {
            $table->dropColumn(['amount','net_amount']);
            $table->double('amount_less_tax',15,2);
            $table->double('net_pi_amount',15,2);
            $table->double('tds_amount',15,2);
            $table->date('payment_due_date',15,2);
            $table->renameColumn('tax_amount', 'tds_percentage');
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
