<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserFriendsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chats', function (Blueprint $table) {
            $table->increments('id');
            $table->string('uuid')->unique();
            $table->text('text');
            $table->string('object_type')->nullable();
            $table->integer('object_id')->nullable();
            $table->tinyInteger('status');
            $table->tinyInteger('is_read');
            $table->integer('from_id')->unsigned()->nullable();
            $table->integer('to_id')->unsigned()->nullable();
            $table->timestamps();
            
        });
        Schema::table('chats', function (Blueprint $table) {
            $table->foreign('from_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('to_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
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
