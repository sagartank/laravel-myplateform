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
        Schema::table('user_contract_sing_otps', function (Blueprint $table) {
            $table->boolean('is_company')->default(0)->after('is_otp_verify');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_contract_sing_otps', function (Blueprint $table) {
            $table->boolean('is_company');
        });
    }
};
