<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMemberProfileUpdatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('member_profile_updates', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('member_id');
            $table->foreign('member_id')
            ->references('id')->on('members')->onDelete('cascade');
            $table->string('name')->nullable();
            $table->string('father_name')->nullable();
            $table->string('mother_name')->nullable();
            $table->string('image')->nullable();
            $table->string('spouse_name')->nullable();
            $table->string('bcs_batch')->nullable();
            $table->date('joining_date')->nullable();
            $table->integer('cader_id')->nullable();
            $table->date('birth_date')->nullable();
            $table->string('gender')->nullable();
            $table->string('mobile')->nullable();
            $table->string('email')->nullable();
            $table->string('password')->nullable();
            $table->text('office_address')->nullable();
            $table->string('nid')->nullable();
            $table->string('nid_front')->nullable();
            $table->string('nid_back')->nullable();
            $table->string('signature')->nullable();
            $table->string('proof_joining_cadre')->nullable();
            $table->string('proof_signed_by_sup_author')->nullable();
            $table->string('present_address')->nullable();
            $table->string('permanent_address')->nullable();
            $table->string('emergency_contact')->nullable();
            //nominee info
            $table->string('nominee_name')->nullable();
            $table->string('nominee_father_name')->nullable();
            $table->string('nominee_mother_name')->nullable();
            $table->string('nominee_image')->nullable();
            $table->date('nominee_birth_date')->nullable();
            $table->string('nominee_gender')->nullable();
            $table->string('nominee_mobile')->nullable();
            $table->text('nominee_relation_with_user')->nullable();
            $table->string('nominee_nid')->nullable();
            $table->string('nominee_nid_front')->nullable();
            $table->string('nominee_nid_back')->nullable();
            $table->longText('nominee_professional_details')->nullable();
            $table->string('nominee_permanent_address')->nullable();

            $table->string('status')->default('pending');
            $table->date('alert_notify')->nullable();

            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('member_profile_updates');
    }
}
