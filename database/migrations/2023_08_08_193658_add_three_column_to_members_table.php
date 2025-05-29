<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddThreeColumnToMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('members', function (Blueprint $table) {
            $table->after('status', function ($table) {
               $table->string('ref_name')->nullable();
               $table->string('ref_mobile')->nullable();
               $table->string('ref_memeber_id_no')->nullable();
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
        Schema::table('members', function (Blueprint $table) {
            $table->dropColumn('ref_name');
            $table->dropColumn('ref_mobile');
            $table->dropColumn('ref_memeber_id_no');
        });
    }
}
