<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMemberChoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('member_choices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('member_id');
            $table->foreign('member_id')
            ->references('id')->on('members')->onDelete('cascade');

            $table->string('pref_of_dcc')->nullable();
            $table->string('pref_close_dcc')->nullable();
            $table->string('flat_size')->nullable();
            $table->string('exp_bank_loan')->nullable();
            $table->string('num_flat_shares')->nullable();

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
        Schema::dropIfExists('member_choices');
    }
}
