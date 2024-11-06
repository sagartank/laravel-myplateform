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
        Schema::create('deals_contract', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('offer_id');
            $table->foreign('offer_id')->references('id')->on('offers')->cascadeOnDelete();
            $table->unsignedBigInteger('seller_id')->nullable();
            $table->string('seller_signature_name')->nullable();
            $table->string('seller_id_no')->nullable();
            $table->string('seller_phone_number')->nullable();
            $table->string('seller_otp')->nullable();
            $table->enum('seller_otp_verify', ['Yes', 'No'])->default('No');
            $table->string('seller_file')->nullable();
            $table->string('seller_contract_file')->nullable();
            $table->unsignedBigInteger('buyer_id')->nullable();
            $table->string('buyer_signature_name')->nullable();
            $table->string('buyer_id_no')->nullable();
            $table->string('buyer_phone_number')->nullable();
            $table->string('buyer_otp')->nullable();
            $table->enum('buyer_otp_verify', ['Yes', 'No'])->default('No');
            $table->string('buyer_file')->nullable();
            $table->string('buyer_contract_file')->nullable();
            $table->string('deals_contract_file')->nullable();
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
        Schema::dropIfExists('deals_contract');
    }
};
