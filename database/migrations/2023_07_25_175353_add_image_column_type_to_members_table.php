<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddImageColumnTypeToMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('members', function (Blueprint $table) {
            $table->string('image')->nullable()->change();
            $table->string('nid_front')->nullable()->change();
            $table->string('nid_back')->nullable()->change();
            $table->string('signature')->nullable()->change();
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
            $table->dropColumn('image');
            $table->dropColumn('nid_front');
            $table->dropColumn('nid_back');
            $table->dropColumn('signature');
            $table->dropColumn('proof_joining_cadre');
            $table->dropColumn('proof_signed_by_sup_author');
        });
    }
}
