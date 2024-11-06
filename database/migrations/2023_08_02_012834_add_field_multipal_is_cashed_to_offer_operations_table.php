<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('offer_operations', function (Blueprint $table) {
            $table->enum('is_disputed', ['Yes', 'No'])->default('No');
            $table->text('disputed_note')->nullable();
            $table->enum('is_cashed_buyer', ['Yes', 'No'])->default('No');
            $table->dateTime('is_cashed_buyer_date')->nullable();
            $table->enum('is_rated_buyer', ['Yes', 'No'])->default('No');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('offer_operations', function (Blueprint $table) {
            //
        });
    }
};
