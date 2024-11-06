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
        Schema::create('issuers', function (Blueprint $table) {
            $table->id();
            $table->uuid('slug')->unique();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('gender', 25)->nullable();
            $table->string('marital_status', 25)->nullable();
            $table->string('company_name');
            $table->string('tradename')->nullable();
            $table->string('ruc_text_id')->nullable();
            $table->string('ruc_code_optional')->nullable();
            $table->string('issuers_image')->nullable();
            $table->string('industry_type')->nullable();
            $table->enum('registry_in_mipo', ['Yes', 'No'])->default('No');
            $table->enum('verified_address', ['Yes', 'No'])->default('No');
            $table->string('address')->nullable();
            $table->string('heading')->nullable();
            $table->string('basic_info')->nullable();
            $table->string('additional_info')->nullable();
            $table->unsignedBigInteger('country_id')->nullable()->constrained();
            $table->unsignedBigInteger('city_id')->nullable()->constrained();
            $table->date('registered_at')->nullable();
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
        Schema::dropIfExists('issuers');
    }
};
