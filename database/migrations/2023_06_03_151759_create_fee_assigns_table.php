<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeeAssignsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fee_assigns', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('member_id');
            $table->foreign('member_id')
            ->references('id')->on('members')->onDelete('cascade');
            $table->integer('fee_setup_id');
            $table->date('assign_date');
            $table->date('fine_date')->nullable();
            $table->boolean('monthly');
            $table->double('amount');
            $table->double('fine_amount')->nullable();
            $table->string('status')->default('Unpaid');
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
        Schema::dropIfExists('fee_assigns');
    }
}
