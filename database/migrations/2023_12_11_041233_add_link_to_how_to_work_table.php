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
        Schema::table('how_to_work', function (Blueprint $table) {
            $table->text('buyer_link')->after('buyer_image')->nullable();
            $table->text('seller_link')->after('seller_image')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('how_to_work', function (Blueprint $table) {
            //
        });
    }
};
