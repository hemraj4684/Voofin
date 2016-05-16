<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDiscoutingView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement( 'CREATE VIEW `idiscounting_request` AS select `pi`.`buyer_id` AS `buyer_id`,`pi`.`seller_id` AS `seller_id`,`d`.`uuid` AS `uuid`,`d`.`id` AS `discountingId`,`cv`.`manualDiscounting` AS `manualDiscounting`,`d`.`pi_id` AS `pi_id`,`inv`.`invoice_number` AS `invoiceNumber`,`c`.`name` AS `buyerName`,`d`.`loan_date` AS `discountingDate`,`pi`.`payment_due_date` AS `dueDate`,`pi`.`net_pi_amount` AS `piAmount`,`d`.`eligibility_percentage` AS `eligiblity`,`d`.`loan_amount` AS `loanAmount`,`d`.`status` AS `status` from ((((`discountings` `d` join `payment_instructions` `pi` on((`d`.`pi_id` = `pi`.`id`))) join `invoices` `inv` on((`pi`.`invoice_id` = `inv`.`id`))) join `companies` `c` on((`pi`.`buyer_id` = `c`.`id`))) join `company_band_view` `cv` on(((`cv`.`seller_id` = `pi`.`seller_id`) and (`cv`.`buyer_id` = `pi`.`buyer_id`))))');

        Schema::table('payment_instructions', function ($table) {
            $table->string('reject_remark');
        });
        
        Schema::table('discountings', function ($table) {
            $table->string('reject_remark');
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
