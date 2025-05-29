<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSmsPurchaseDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sms_purchase_details', function (Blueprint $table) {
            $table->id();
            $table->string('order_id');
            $table->string('customer_order_id');
            $table->double('amount');
            $table->string('invoice_no');
            $table->string('sp_message');
            $table->string('method');
            $table->date('date_time');
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
        Schema::dropIfExists('sms_purchase_details');
    }
}
