<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFineStatusToFeeAssignsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fee_assigns', function (Blueprint $table) {
            $table->after('status', function($table){
                $table->string('fine_status')->nullable();
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
        Schema::table('fee_assigns', function (Blueprint $table) {
            $table->dropColumn('fine_status');
        });
    }
}
