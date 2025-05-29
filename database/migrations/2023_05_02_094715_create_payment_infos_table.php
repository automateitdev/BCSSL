<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentInfosTable extends Migration
{


    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_infos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('invoice_no');
            $table->foreignId('member_id')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('ledger_id')->onUpdate('cascade')->onDelete('cascade');
            $table->double('fine_amount');
            $table->double('payable_amount');
            $table->double('total_amount');
            // $table->string('trx_id')->nullable();
            $table->integer('status');
            $table->date('payment_date');
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
        Schema::dropIfExists('payment_infos');
    }
}
