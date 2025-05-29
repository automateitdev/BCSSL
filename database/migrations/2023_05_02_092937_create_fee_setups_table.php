<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeeSetupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fee_setups', function (Blueprint $table) {
            $table->increments('id');
            $table->string('fee_head');
            $table->foreignId('ledger_id')->onUpdate('cascade')->onDelete('cascade');
            $table->date('date')->nullable();
            $table->boolean('monthly');
            $table->double('fine');
            $table->double('amount');
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
        Schema::dropIfExists('fee_setups');
    }
}
