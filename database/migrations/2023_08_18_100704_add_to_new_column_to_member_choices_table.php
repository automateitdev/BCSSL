<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddToNewColumnToMemberChoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('member_choices', function (Blueprint $table) {
            $table->after('member_id', function($table) {
                $table->string('project_type')->nullable();
                $table->json('prefered_area')->nullable();
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
            $table->dropColumn('project_type');
            $table->dropColumn('prefered_area');
        });
    }
}
