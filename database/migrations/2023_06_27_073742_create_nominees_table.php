<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNomineesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nominees', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('member_id');
            $table->foreign('member_id')
            ->references('id')->on('members')->onDelete('cascade');


            $table->string('name');
            $table->string('father_name');
            $table->string('mother_name');
            $table->string('image');
            $table->date('birth_date');
            $table->string('gender');
            $table->string('mobile');
            $table->string('email')->nullable();
            $table->text('relation_with_user');
            $table->string('nid');
            $table->string('nid_front')->nullable();
            $table->string('nid_back')->nullable();
            $table->longText('professional_details')->nullable();
            $table->string('permanent_address')->nullable();

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
        Schema::dropIfExists('nominees');
    }
}
