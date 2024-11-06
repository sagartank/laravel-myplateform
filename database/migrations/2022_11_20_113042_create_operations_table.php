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
        Schema::create('operations', function (Blueprint $table) {
            $table->id();
            $table->uuid('slug')->unique();
            $table->unsignedBigInteger('operation_id')->unique();
            $table->string('operation_number')->unique();
            $table->string('operation_type')->nullable();
            $table->enum('is_government_contract', ['Yes', 'No'])->nullable();
            $table->enum('responsibility', ['With', 'Without'])->nullable();
            $table->string('preferred_payment_method')->nullable();
            $table->string('contract_title')->nullable();
            $table->string('description')->nullable();
            $table->unsignedBigInteger('seller_id');
            $table->foreign('seller_id')->references('id')->on('users');
            $table->unsignedBigInteger('issuer_id')->nullable();
            $table->string('preferred_currency')->nullable();
            $table->string('amount')->nullable();
            $table->string('amount_requested')->nullable();
            $table->boolean('accept_below_requested')->default(false);
            $table->string('check_number')->nullable();
            $table->enum('invoice_type', ['Service', 'Product'])->nullable();
            $table->string('issuer_company_type')->nullable();
            $table->string('invoice_number')->nullable();
            $table->string('tax_id')->nullable();
            $table->string('timbrado')->nullable();
            $table->string('authorized_personnel')->nullable();
            $table->string('authorized_personnel_signature')->nullable();
            $table->unsignedBigInteger('issuer_bank_id')->nullable();
            $table->boolean('bcp')->nullable();
            $table->boolean('inforconf')->nullable();
            $table->boolean('infocheck')->nullable();
            $table->boolean('criterium')->nullable();
            $table->enum('cheque_status', ['Postponed', 'Todate'])->nullable();
            $table->enum('cheque_type', ['Crossed', 'Open'])->nullable();
            $table->enum('cheque_payee_type', ['Anyone', 'Named'])->nullable();
            $table->date('issuance_date')->nullable();
            $table->date('expiration_date')->nullable();
            $table->string('extra_expiration_days', 50)->nullable();
            $table->enum('operations_status', ['Draft', 'Pending', 'Rejected', 'Approved'])->default('Draft');
            $table->enum('mipo_verified', ['Yes', 'No'])->default('No');
            $table->string('mipo_comment')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->string('rejection_note')->nullable();
            $table->boolean('auto_expire')->default(false);
            $table->timestamp('expired_at')->nullable();
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
        Schema::dropIfExists('operations');
    }
};
