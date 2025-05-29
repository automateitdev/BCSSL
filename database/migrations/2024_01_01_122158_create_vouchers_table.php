<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVouchersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vouchers', function (Blueprint $table) {
            $table->id();
            $table->string('voucher_id');
            $table->foreignId('ledger_from_id');
            $table->foreignId('ledger_to_id');
            $table->decimal('amount', 10, 2);
            $table->enum('state', ['pending', 'approved', 'declined'])->default('pending');
            $table->string('type');
            $table->string('reference', 200);
            $table->longText('description');
            $table->timestamp('date');
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
        Schema::dropIfExists('vouchers');
    }
}
