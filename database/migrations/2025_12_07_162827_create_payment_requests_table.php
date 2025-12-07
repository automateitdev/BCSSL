<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('payment_requests', function (Blueprint $table) {
            $table->id();
            $table->string('invoice')->unique();
            $table->string('session_token')->unique()->nullable();
            $table->json('fee_assign_ids');
            $table->decimal('total_amount', 10, 2);
            $table->string('status')->default('pending'); // pending, success, failed
            $table->string('spg_transaction_id')->nullable();
            $table->string('gateway_status_code')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->unsignedBigInteger('creator_id');
            $table->string('created_by');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('payment_requests');
    }
};
