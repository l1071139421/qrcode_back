<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Report extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('report', function (Blueprint $table) {
            $table->increments('id');
            $table->string('item_id');
            $table->integer('bill');
            $table->integer('bill_degree');
            $table->integer('degree');
            $table->integer('type');
            $table->string('user_id');
            $table->date('date');
            $table->timestamps();
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
        Schema::drop('report');
    }
}
