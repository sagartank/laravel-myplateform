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
        Schema::create('offers', function (Blueprint $table) {
            $table->id();
            $table->uuid('slug')->unique();
            $table->unsignedBigInteger('buyer_id');
            $table->foreign('buyer_id')->references('id')->on('users')->cascadeOnDelete();
            $table->string('preferred_payment_method');
            $table->string('amount');
            $table->string('retention')->nullable();
            $table->string('mipo_commission')->nullable();
            $table->string('mipo_plus_commission')->nullable();
            $table->string('net_profit')->nullable();
            $table->enum('is_mipo_plus', ['Yes', 'No'])->default('No');
            $table->enum('offer_status', ['Approved', 'Rejected', 'Pending', 'Counter', 'Completed'])->default('Pending');
            $table->enum('offer_type', ['Single', 'Group']);
            $table->enum('is_disputed', ['Yes', 'No'])->default('No');
            $table->enum('is_rated_buyer', ['Yes', 'No'])->default('No');
            $table->enum('is_cashed_buyer', ['Yes', 'No'])->default('No');
            $table->enum('is_rated_seller', ['Yes', 'No'])->default('No');
            $table->enum('is_cashed_seller', ['Yes', 'No'])->default('No');
            $table->enum('is_filed_buyer', ['Yes', 'No'])->default('No');
            $table->enum('is_filed_seller', ['Yes', 'No'])->default('No');
            $table->enum('is_qr_code_buyer', ['Yes', 'No'])->default('No');
            $table->enum('is_qr_code_seller', ['Yes', 'No'])->default('No');
            $table->enum('is_payment_buyer', ['Yes', 'No'])->default('No');
            $table->enum('is_payment_seller', ['Yes', 'No'])->default('No');
            $table->enum('is_mipo_commission_payment', ['Yes', 'No'])->default('No');
            $table->enum('deals_status', ['Pending', 'Inprogress', 'Completed'])->nullable();
            $table->enum('is_seller_deals_contract', ['Yes', 'No'])->default('No');
            $table->enum('is_buyer_deals_contract', ['Yes', 'No'])->default('No');
            $table->timestamp('expires_at');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('offers');
    }
};
