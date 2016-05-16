<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBandsConfigurations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bands', function ($table) {
            $table->softDeletes();
            $table->dropColumn('configurations');
            $table->string('discounting');
            $table->string('manualDiscounting');
            $table->string('autoDiscounting');
            $table->tinyInteger('status');;
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
