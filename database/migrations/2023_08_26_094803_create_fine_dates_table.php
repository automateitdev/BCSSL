<?php

use App\Models\FineDate;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFineDatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fine_dates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fee_assign_id')->nullable()->constrained('fee_assigns', 'id')->onDelete('cascade');
            $table->dateTime('find_date');
            $table->string('status')->default(FineDate::STATUS_INCOMPLETE);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fine_dates');
    }
}
