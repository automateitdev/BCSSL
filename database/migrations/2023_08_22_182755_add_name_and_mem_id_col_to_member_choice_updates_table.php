<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNameAndMemIdColToMemberChoiceUpdatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('member_choice_updates', function (Blueprint $table) {
            $table->after('capacity_range', function($table) {
                $table->string('p_introducer_name')->nullable();
                $table->json('p_introducer_member_num')->nullable();
            });
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('member_choice_updates', function (Blueprint $table) {
            $table->dropColumn('p_introducer_name');
            $table->dropColumn('p_introducer_member_num');
        });
    }
}
