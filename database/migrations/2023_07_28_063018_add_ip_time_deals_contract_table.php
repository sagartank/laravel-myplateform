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
        Schema::table('deals_contract', function (Blueprint $table) {
            $table->string('seller_ip', 100)->nullable()->after('seller_otp_verify');
            $table->dateTime('seller_date_time')->nullable()->after('seller_ip');
            $table->string('buyer_ip', 100)->nullable()->after('buyer_otp_verify');
            $table->dateTime('buyer_date_time')->nullable()->after('buyer_ip');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('deals_contract', function (Blueprint $table) {
            //
        });
    }
};
