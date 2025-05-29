<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewColumnToNomineesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('nominees', function (Blueprint $table) {
            $table->after('mobile', function ($table) {
                $table->string('formatted_number')->unique()->nullable();
                $table->string('country_code')->nullable();
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
        Schema::table('nominees', function (Blueprint $table) {
            //
        });
    }
}
