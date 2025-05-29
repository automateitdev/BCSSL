<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddExtraColumnToMemberProfileUpdatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('member_profile_updates', function (Blueprint $table) {
            $table->after('mobile', function ($table) {
                $table->string('formatted_number')->unique()->nullable();
                $table->string('country_code')->nullable();
            });
            $table->after('nominee_mobile', function ($table) {
                $table->string('nominee_formatted_number')->unique()->nullable();
                $table->string('nominee_country_code')->nullable();
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
        Schema::table('member_profile_updates', function (Blueprint $table) {
            $table->dropColumn('formatted_number');
            $table->dropColumn('country_code');
            $table->dropColumn('nominee_formatted_number');
            $table->dropColumn('nominee_country_code');
        });
    }
}
