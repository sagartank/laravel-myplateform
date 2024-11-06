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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->uuid('slug')->unique();
            $table->unsignedBigInteger('referrer_id')->nullable();
            $table->foreign('referrer_id')->references('id')->on('users');
            $table->string('referral_code')->nullable()->unique();
            $table->string('name')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            //            $table->string('username', 100)->unique()->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            // $table->string('phone_number', 20)->unique()->nullable();
            $table->string('phone_number', 20)->nullable();
            $table->string('password');
            $table->timestamp('password_changed_at')->nullable();
            $table->rememberToken();
            $table->boolean('is_admin')->default(0);
            $table->unsignedInteger('otp')->nullable();
            $table->boolean('is_otp_verified')->default(0);
            $table->enum('security_level', ['Secure', 'Medium','Risky'])->default('Secure');
            $table->enum('user_level', ['Noobie', 'Bronze','Silver', 'Gold', 'Platinum'])->default('Noobie');
            $table->unsignedBigInteger('issuer_id')->nullable();
            $table->date('birth_date')->nullable();
            $table->string('gender', 20)->nullable();
            $table->string('profile_image')->nullable();
            $table->text('address')->nullable();
            $table->string('address_verify_otp', 20)->nullable();
            $table->string('address_authorise_name',100)->nullable();
            $table->string('address_qr_code', 200)->nullable();
            $table->enum('address_verify', ['Yes', 'No'])->default('No');
            $table->timestamp('address_verify_at')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('postal_code')->nullable();
            $table->unsignedBigInteger('country_id')->nullable()->constrained();
            $table->string('ruc_tax_id')->nullable();
            $table->string('ipv_code', 20)->nullable();
            $table->string('ipv_image')->nullable();
            $table->boolean('is_ipv_verified')->default(0);
            $table->string('occupation')->nullable();
            $table->text('bio')->nullable();
            $table->string('preferred_payment_method')->nullable();
            $table->string('estimated_budget')->nullable();
            $table->boolean('as_borrower')->default(0);
            $table->boolean('as_investor')->default(0);
            $table->enum('account_type', ['Individual', 'Enterprise'])->nullable();
            $table->unsignedInteger('ent_no_of_users')->nullable();
            $table->unsignedInteger('ent_no_of_deals_per_day')->nullable();
            $table->string('ent_business_type')->nullable();
            $table->unsignedBigInteger('enterprise_id')->nullable();
            $table->foreign('enterprise_id')->references('id')->on('users');
            $table->unsignedSmallInteger('registration_step')->default(0);
            $table->string('preferred_language')->default('en');
            $table->enum('preferred_contact_method', ['Email', 'Phone'])->nullable();
            $table->enum('preferred_dashboard', ['Borrower', 'Investor'])->nullable();
            $table->string('preferred_currency')->nullable();
            $table->boolean('is_registered')->nullable();
            $table->timestamp('registered_at')->nullable();
            $table->boolean('is_active')->default(1);
            $table->tinyInteger('is_user_company')->default(0);
            $table->string('attach_company_documents')->nullable();
            $table->ipAddress('last_login_ip')->nullable();
            $table->timestamp('last_login_at')->nullable();
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
        Schema::dropIfExists('users');
    }
};
