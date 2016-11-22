<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEDCsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('edcs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('account_kredit_id')->unsigned()->nullable();
            $table->integer('account_debit_id')->unsigned()->nullable();
            $table->timestamps();
            $table->foreign('account_debit_id')->references('id')->on('accounts')->onDelete('cascade');
            $table->foreign('account_kredit_id')->references('id')->on('accounts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('edcs');
    }
}
