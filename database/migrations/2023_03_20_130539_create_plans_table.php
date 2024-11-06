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
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->decimal('price')->default('0.00');
            $table->decimal('offer_price')->default('0.00');
            $table->string('currency',3);
            $table->enum('duration', ['month', 'year'])->default('month');
            $table->mediumInteger('sort_order')->unsigned()->default(0);
            $table->boolean('is_free_plan')->default(0);
            $table->enum('suitable_for_account_type', ['Individual', 'Enterprise'])->nullable();
            $table->enum('suitable_for_account_opener', ['Borrower', 'Investor'])->nullable();

            $table->string('buy_sell')->nullable();
            $table->string('basic_dashboard')->nullable();
            $table->string('enterprise_dashboard')->nullable();
            $table->string('multi_user_account')->nullable();
            $table->string('exportable_pdf')->nullable();
            $table->string('offer_notifications')->nullable();
            $table->string('legal_advice')->nullable();
            $table->string('monthly_reports')->nullable();
            $table->string('newsletters')->nullable();
            $table->string('investor_commission')->nullable();

            $table->boolean('is_active')->default(1);
            $table->timestamps();
            $table->softDeletes();
            // Indexes
            $table->unique('slug');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('plans');
    }
};
