<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProofFileToPaymentInfos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payment_infos', function (Blueprint $table) {
            $table->after('ledger_id', function($table){
                $table->string('document_files')->nullable();
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
        Schema::table('payment_infos', function (Blueprint $table) {
            $table->dropColumn('document_files');
        });
    }
}
