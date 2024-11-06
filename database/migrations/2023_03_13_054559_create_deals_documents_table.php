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
        Schema::create('deals_documents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('offer_id');
            $table->foreign('offer_id')->references('id')->on('offers')->cascadeOnDelete();
            $table->unsignedBigInteger('step_id');
            $table->string('name');
            $table->string('path');
            $table->unsignedDecimal('size')->nullable();
            $table->string('extension', 20)->nullable();
            $table->unsignedInteger('last_modified')->nullable();
            $table->string('uploaded_by_name')->nullable();
            $table->unsignedBigInteger('uploaded_by')->nullable();
            $table->enum('upload_type', ['deals_attached_file', 'deals'])->default('deals_attached_file');
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
        Schema::dropIfExists('deals_documents');
    }
};
