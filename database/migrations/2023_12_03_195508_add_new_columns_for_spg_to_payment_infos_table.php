<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewColumnsForSpgToPaymentInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payment_infos', function (Blueprint $table) {
            $table->integer('payment_status')->nullable();
            $table->integer('status_code')->nullable();
            $table->string('transaction_id',50)->nullable();
            $table->datetime('transaction_date')->nullable();
            $table->string('br_code')->nullable();
            $table->string('pay_mode')->nullable();
            $table->double('vat', 8, 2)->nullable();
            $table->double('commission', 8, 2)->nullable();
            $table->string('scroll_no')->nullable();
            $table->string('session_token')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('payment_infos', function (Blueprint $table) {
            //
        });
    }
}
