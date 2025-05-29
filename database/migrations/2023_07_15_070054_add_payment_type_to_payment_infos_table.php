<?php

use App\Models\PaymentInfo;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPaymentTypeToPaymentInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payment_infos', function (Blueprint $table) {
            $table->string('payment_type')->default(PaymentInfo::PAYMENT_TYPE_MANUAL);
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
            $table->dropColumn('payment_type');
        });
    }
}
