<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('uuid')->unique();
            $table->string('name');
            $table->string('salt');
            $table->string('email')->unique();
            $table->string('password', 60);
            $table->string('user_type', 25);
            $table->text('device_id');
            $table->text('auth_token');
            $table->string('ip_address', 15);
            $table->string('browser_token');
            $table->dateTime('last_login');
            $table->tinyInteger('status');
            $table->integer('created_by');
            $table->integer('updated_by');
            $table->rememberToken();
            $table->timestamps();
        });
        
        Schema::create('user_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->date('dob');
            $table->text('address');
            $table->string('picode', 15);
            $table->string('city');
            $table->string('state');
            $table->string('country');
        });
        
        
    }
    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('users');
        Schema::drop('user_details');
    }
}
