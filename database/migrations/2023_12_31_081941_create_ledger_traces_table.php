<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLedgerTracesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ledger_traces', function (Blueprint $table) {
            $table->increments('id');
            $table->string('type');
            $table->string('voucher_id');
            $table->string('invoice_no');
            $table->foreignId('ledger_id');
            $table->foreignId('feehead_id')->nullable();
            $table->double('debit')->nullable();
            $table->double('credit')->nullable();
            $table->string('reference')->nullable();
            $table->longText('description')->nullable();
            $table->timestamp('voucher_date');
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
        Schema::dropIfExists('ledger_traces');
    }
}
