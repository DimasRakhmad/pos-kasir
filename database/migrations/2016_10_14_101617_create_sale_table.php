<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSaleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('transaction_id')->unsigned();
            $table->integer('table_id')->unsigned()->nullable();
            $table->double('subtotal',20,2);
            $table->double('discount',20,2)->default(0);
            $table->string('status');
            $table->string('order_type');
            $table->string('memo');
            $table->string('pay_type');
            $table->integer('edc_id')->unsigned()->nullable();
            $table->integer('member_id')->unsigned()->nullable();
            $table->integer('waiters_id')->unsigned()->nullable();
            $table->timestamps();
            $table->foreign('transaction_id')->references('id')->on('transactions')->onDelete('cascade');
            $table->foreign('waiters_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('edc_id')->references('id')->on('edcs')->onDelete('cascade');
            $table->foreign('member_id')->references('id')->on('members')->onDelete('cascade');
            $table->foreign('table_id')->references('id')->on('tables')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('sales');
    }
}
