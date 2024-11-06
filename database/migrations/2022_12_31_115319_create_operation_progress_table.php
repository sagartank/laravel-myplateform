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
        Schema::create('operation_progress', function (Blueprint $table) {
            $table->id();
            $table->uuid('slug')->unique();
            $table->enum('step_type', ['Buyer', 'Seller'])->default('Buyer');
            $table->string('step_links')->nullable();
            $table->string('title_en')->nullable();
            $table->string('title_es')->nullable();
            $table->string('description')->nullable();
            $table->enum('cashed', ['Yes', 'No'])->default('No');
            $table->enum('rate', ['Yes', 'No'])->default('No');
            $table->enum('file_upload', ['Yes', 'No'])->default('No');
            $table->enum('qr_code', ['Yes', 'No'])->default('No');
            $table->enum('payment', ['Yes', 'No'])->default('No');
            $table->enum('mipo_commission_payment', ['Yes', 'No'])->default('No');
            $table->enum('manual_trigger', ['Self', 'User', 'Admin', 'None'])->default('None');
            $table->enum('is_active', ['Yes', 'No'])->default('No');
            $table->unsignedBigInteger('order_position')->nullable();
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
        Schema::dropIfExists('operation_progress');
    }
};
