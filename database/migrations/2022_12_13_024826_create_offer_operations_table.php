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
        Schema::create('offer_operations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('offer_id')->constrained()->cascadeOnDelete();
            $table->foreignId('operation_id')->constrained();
            $table->string('offer_retention')->nullable();
            $table->string('offer_deal_mode')->nullable();
            $table->string('offer_time')->nullable();
            $table->enum('offer_time_type', ['Hour', 'Day'])->default('Hour');
            $table->string('offer_amount')->nullable();
            $table->enum('offer_mipo_plus', ['Yes', 'No'])->default('No');
            $table->tinyInteger('is_offered')->default(0);
            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('offer_operations');
    }
};
