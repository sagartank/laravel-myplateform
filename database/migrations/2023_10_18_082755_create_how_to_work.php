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
        Schema::create('how_to_work', function (Blueprint $table) {
            $table->id();
            $table->uuid('slug')->unique();
            $table->json('heading_text_buyer');
            $table->json('sub_heading_text_buyer');
            $table->json('button_text_buyer');
            $table->string('buyer_image');
            $table->json('heading_text_seller');
            $table->json('sub_heading_text_seller');
            $table->json('button_text_seller');
            $table->string('seller_image');
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
        Schema::dropIfExists('how_to_work');
    }
};
