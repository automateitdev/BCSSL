<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTwoColumnToMemberChoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('member_choices', function (Blueprint $table) {
            $table->after('num_flat_shares', function($table){
                $table->string('distict_pref')->nullable();
                $table->string('capacity_range')->nullable();
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
        Schema::table('member_choices', function (Blueprint $table) {
            $table->dropColumn('distict_pref');
            $table->dropColumn('capacity_range');
        });
    }
}
