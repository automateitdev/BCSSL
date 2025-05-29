<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssocsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assocs', function (Blueprint $table) {
            $table->increments('id');
            $table->foreignId('user_id')->onUpdate('cascade')->onDelete('cascade');
            $table->bigInteger('member_no')->unique();
            $table->date('join_date');
            $table->string('share_no')->nullable();
            $table->integer('share_quantity')->nullable();
            $table->string('bcs_batch');
            $table->string('company');
            $table->string('designation');
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
        Schema::dropIfExists('assocs');
    }
}
