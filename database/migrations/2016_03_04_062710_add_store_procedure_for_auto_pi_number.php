<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStoreProcedureForAutoPiNumber extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       DB::unprepared('CREATE PROCEDURE getPiNumber(IN invoice_id INT,IN buyer_id INT) 

                       BEGIN 
                             DECLARE pi VARCHAR(15);

                             SET pi=CONCAT(
                                 (SELECT CONCAT(LEFT(UPPER(cb.name),2), LEFT(UPPER(cs.name),2)) as str1 FROM invoices inv INNER JOIN companies cb ON cb.id=inv.buyer_id INNER JOIN companies cs ON  cs.id=inv.seller_id WHERE inv.id=invoice_id),
                                 (SELECT LPAD(count(*)+1,7,0) FROM payment_instructions WHERE buyer_id=buyer_id)
                             ) ;
                            
                            SELECT pi;
                             
                       END');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS getPiNumber');
                
    }
}