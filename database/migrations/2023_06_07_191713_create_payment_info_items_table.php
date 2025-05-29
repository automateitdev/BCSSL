<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentInfoItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_info_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('payment_info_id');
            $table->unsignedBigInteger('fee_assign_id');
            $table->date('assign_date');
            $table->double('amount');
            $table->double('fine_amount')->nullable();
            $table->boolean('monthly')->comment('1=monthly, 0=on time');
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
        Schema::dropIfExists('payment_info_items');
    }
}
