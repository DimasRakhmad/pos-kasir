<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableTransactionDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('transaction_id')->unsigned();
            $table->integer('item_id')->unsigned()->nullable();
            $table->integer('menu_id')->unsigned()->nullable();
            $table->integer('price');
            $table->string('notes');
            $table->integer('qty');
            $table->integer('subtotal');
            $table->double('discount',20,2);
            $table->double('total',20,2);
            $table->timestamps();
            $table->foreign('transaction_id')->references('id')->on('transactions')->onDelete('cascade');
            $table->foreign('item_id')->references('id')->on('items')->onDelete('cascade');
            $table->foreign('menu_id')->references('id')->on('menus')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('transaction_details');
    }
}
