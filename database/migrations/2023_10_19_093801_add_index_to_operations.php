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
        Schema::table('operations', function (Blueprint $table) {
            $table->index('operation_type');
            $table->index('operations_status');
            $table->index('preferred_currency');
            $table->index('responsibility');
            $table->index('preferred_payment_method');
            $table->index('mipo_verified');
            $table->index(['issuance_date', 'expiration_date']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('operations', function (Blueprint $table) {
            //
        });
    }
};
