<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangesInPiViewAndIdiscountingRequestView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('DROP VIEW `pi_view`');
        DB::statement('CREATE VIEW `pi_view` AS select `pi`.`updated_at` AS `pi_approval_date`,`pi`.`id` AS `pi_id`,`pi`.`uuid` AS `pi_uuid`,`pi`.`pi_number` AS `pi_number`,`pi`.`net_pi_amount` AS `pi_net_amount`,`pi`.`amount_less_tax` AS `pi_amount`,`pi`.`tds_percentage` AS `tds_percentage`,`pi`.`tds_amount` AS `tds_amount`,`pi`.`payment_due_date` AS `due_date`,`pi`.`status` AS `pi_status`,`inv`.`id` AS `invoice_id`,`inv`.`uuid` AS `invoice_uuid`,`inv`.`purchase_order_id` AS `po_id`,`inv`.`invoice_number` AS `invoice_number`,`inv`.`final_amount` AS `invoice_final_amount`,`inv`.`due_date` AS `invoice_due_date`,`inv`.`status` AS `invoice_status`,`inv`.`currency` AS `invoice_currency`,`inv`.`tax_details` AS `tax_details`,`inv`.`discount_type` AS `discount_type`,`inv`.`discount` AS `invoice_discount`,`inv`.`amount` AS `invoice_amount`,`pi`.`seller_id` AS `seller_id`,`pi`.`buyer_id` AS `buyer_id` from (`payment_instructions` `pi` left join `invoices` `inv` on((`pi`.`invoice_id` = `inv`.`id`)))');
        DB::statement('DROP VIEW `idiscounting_request`');
        DB::statement('CREATE VIEW `idiscounting_request` AS select `pi`.`uuid` AS `pi_uuid`,`inv`.`final_amount` AS `invoiceAmt`,`inv`.`currency` AS `currency`,`d`.`loan_date` AS `loan_date`,`pi`.`pi_number` AS `pi_number`,`pi`.`net_pi_amount` AS `net_pi_amount`,`pi`.`buyer_id` AS `buyer_id`,`pi`.`seller_id` AS `seller_id`,`d`.`uuid` AS `uuid`,`d`.`id` AS `discountingId`,`cv`.`manualDiscounting` AS `manualDiscounting`,`d`.`pi_id` AS `pi_id`,`inv`.`invoice_number` AS `invoiceNumber`,`c`.`name` AS `buyerName`,`d`.`loan_date` AS `discountingDate`,`pi`.`payment_due_date` AS `dueDate`,`pi`.`net_pi_amount` AS `piAmount`,`d`.`eligibility_percentage` AS `eligiblity`,`d`.`loan_amount` AS `loanAmount`,`d`.`status` AS `status` from ((((`discountings` `d` join `payment_instructions` `pi` on((`d`.`pi_id` = `pi`.`id`))) join `invoices` `inv` on((`pi`.`invoice_id` = `inv`.`id`))) join `companies` `c` on((`pi`.`buyer_id` = `c`.`id`))) join `company_band_view` `cv` on(((`cv`.`seller_id` = `pi`.`seller_id`) and (`cv`.`buyer_id` = `pi`.`buyer_id`))))');
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
