<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditDiscountings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('discountings', function (Blueprint $table) {
            $table->renameColumn('maturity_date', 'loan_date');
            $table->renameColumn('remittence_amount', 'loan_amount');
            $table->string('other_charges')->change();
            $table->double('eligibility_percentage',15,2);
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
