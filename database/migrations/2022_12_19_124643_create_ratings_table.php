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
        Schema::create('ratings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->nullableMorphs('ratingable');
            $table->string('rating_number')->nullable();
            $table->string('feedback_transaction')->nullable();
            $table->string('feedback_document')->nullable();
            $table->enum('feedback_cashing', ['Yes', 'No'])->default('No');
            $table->string('feedback_title')->nullable();
            $table->string('feedback_description')->nullable();
            $table->string('issuers_transaction')->nullable();
            $table->string('issuers_document')->nullable();
            $table->enum('issuers_cashing', ['Yes', 'No'])->default('No');
            $table->string('issuers_title')->nullable();
            $table->string('issuers_description')->nullable();
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
        Schema::dropIfExists('ratings');
    }
};
