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
        Schema::create('bank_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->unsignedBigInteger('bank_id');
            $table->enum('payment_options', ['Cash', 'eWallet', 'Bank', 'Other']);
            $table->string('bank_name', 50)->nullable();
            $table->string('account_name', 50)->nullable();
            $table->string('account_number', 50)->nullable();
            $table->string('phone_company', 20)->nullable();
            $table->string('phone_number', 20)->nullable();
            $table->string('identification_id', 50)->nullable();
            $table->text('payment_note')->nullable();
            $table->enum('is_active', ['Yes', 'No'])->default('Yes');
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
        Schema::dropIfExists('bank_details');
    }
};
