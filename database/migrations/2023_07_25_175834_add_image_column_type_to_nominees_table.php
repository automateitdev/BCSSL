<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddImageColumnTypeToNomineesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('nominees', function (Blueprint $table) {
            $table->string('image')->nullable()->change();
            $table->string('nid_front')->nullable()->change();
            $table->string('nid_back')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('nominees', function (Blueprint $table) {
            $table->dropColumn('image');
            $table->dropColumn('nid_front');
            $table->dropColumn('nid_back');
        });
    }
}
