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
        Schema::create('offers_history', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('offer_id');
            $table->foreign('offer_id')->references('id')->on('offers')->cascadeOnDelete();
            $table->string('preferred_payment_method')->nullable();
            $table->string('amount')->nullable();
            $table->string('retention')->nullable();
            $table->string('mipo_commission')->nullable();
            $table->string('mipo_plus_commission')->nullable();
            $table->string('net_profit')->nullable();
            $table->enum('is_mipo_plus', ['Yes', 'No'])->default('No');
            $table->enum('offer_status', ['Approved', 'Rejected', 'Pending', 'Counter', 'Completed'])->default('Pending');
            $table->enum('offer_type', ['Single', 'Group']);
            $table->timestamp('expires_at');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
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
        Schema::dropIfExists('offers_history');
    }
};
