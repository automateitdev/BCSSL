<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('father_name');
            $table->string('mother_name');
            $table->string('image');
            $table->string('spouse_name')->nullable();
            $table->date('birth_date');
            $table->string('gender');
            $table->string('blood_group');
            $table->string('user_type')->default('member');
            $table->string('mobile')->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();

            $table->string('current_occupation')->nullable();
            $table->string('current_designation')->nullable();
            $table->date('current_occupation_joining')->nullable();
            $table->string('current_office_address')->nullable();

            $table->string('nid');
            $table->string('nid_front');
            $table->string('nid_back');
            $table->string('signature');
            $table->string('present_address')->nullable();
            $table->string('permanent_address')->nullable();
            $table->string('emergency_contact')->nullable();
            $table->string('status')->default('inactive');
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
        Schema::dropIfExists('members');
    }
}
