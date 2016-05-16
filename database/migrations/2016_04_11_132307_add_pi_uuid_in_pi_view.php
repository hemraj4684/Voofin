<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPiUuidInPiView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       DB::statement('DROP VIEW `pi_view`');
       DB::statement('CREATE VIEW `pi_view` AS select `pi`.`id` AS `pi_id`,`pi`.`uuid` AS `pi_uuid`,`pi`.`pi_number` AS `pi_number`,`pi`.`net_pi_amount` AS `pi_net_amount`,`pi`.`amount_less_tax` AS `pi_amount`,`pi`.`tds_percentage` AS `tds_percentage`,`pi`.`tds_amount` AS `tds_amount`,`pi`.`payment_due_date` AS `due_date`,`pi`.`status` AS `pi_status`,`inv`.`id` AS `invoice_id`,`inv`.`uuid` AS `invoice_uuid`,`inv`.`purchase_order_id` AS `po_id`,`inv`.`invoice_number` AS `invoice_number`,`inv`.`final_amount` AS `invoice_final_amount`,`inv`.`due_date` AS `invoice_due_date`,`inv`.`status` AS `invoice_status`,`inv`.`currency` AS `invoice_currency`,`inv`.`tax_details` AS `tax_details`,`inv`.`discount_type` AS `discount_type`,`inv`.`discount` AS `invoice_discount`,`inv`.`amount` AS `invoice_amount`,`pi`.`seller_id` AS `seller_id`,`pi`.`buyer_id` AS `buyer_id` from (`payment_instructions` `pi` left join `invoices` `inv`   on(`pi`.`invoice_id` = `inv`.`id`))');
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
