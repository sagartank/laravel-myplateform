<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid as PackageUuid;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);


       /*  DB::insert(DB::raw("INSERT INTO `users` (`id`, `slug`, `name`, `first_name`, `last_name`, `email`, `email_verified_at`, `phone_number`, `password`, `password_changed_at`, `remember_token`, `is_admin`, `otp`, `is_otp_verified`, `birth_date`, `gender`, `profile_image`, `address`, `city`, `state`, `postal_code`, `country_id`, `ruc_tax_id`, `id_proof_doc`, `ipv_code`, `ipv_image`, `is_ipv_verified`, `occupation`, `bio`, `preferred_payment_method`, `estimated_budget`, `as_borrower`, `as_investor`, `account_type`, `ent_no_of_users`, `ent_no_of_deals_per_day`, `ent_business_type`, `enterprise_id`, `registration_step`, `preferred_language`, `preferred_contact_method`, `preferred_dashboard`, `preferred_currency`, `is_registered`, `registered_at`, `is_active`, `last_login_ip`, `last_login_at`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
        (1, '447e95fa-b912-4359-bdbe-7f911c5e5ff3', 'Mipo Admin', 'Mipo', 'Admin', 'admin@mipo.com', NULL, NULL, '$2y$10$8tOfdyuMJgIrsT4LfiRz6e.SEbJXW6rDmECTSVeqEFUF1/izyh6f6', NULL, NULL, 1, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, 0, 'en', NULL, NULL, NULL, 0, NULL, 1, NULL, NULL, NULL, 1, '2022-11-15 17:08:50', '2022-11-24 05:10:10', NULL),
        (2, 'fd76b81d-8dde-4f62-a082-f3d007214cd4', 'Colton Mccall', 'Colton', 'Mccall', 'user@mipo.com', NULL, '+911212121212', '$2y$10\$DLKekjzYJvY8Td5ADTJ87ueU4nLUd4EmcicPtwsUs4lZf7M8iY0ya', NULL, NULL, 0, NULL, 1, '1977-04-20', 'Male', NULL, 'Officiis magnam perf', 'Ab ad consequatur a', 'Qui cupidatat nesciu', 'Quo tenetur alias ma', 99, 'Dolores iure volupta', NULL, 'X7AGVW', NULL, 0, 'Sed consectetur ut n', 'Illum omnis quo sed', 'Cash', '10000', 0, 1, 'enterprise', 1, 1, 'Officiis distinctio', NULL, 4, 'en', NULL, NULL, NULL, 0, NULL, 1, NULL, NULL, NULL, 4, '2022-11-22 01:26:52', '2022-11-24 13:51:04', NULL)")); */
        
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        DB::table('users')->truncate();

        DB::table('roles')->truncate();

        DB::table('role_user')->truncate();
        
        DB::table('permission_role')->truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    
        DB::table('users')->insert([
            'slug' => PackageUuid::uuid4()->toString(),
            'name' => 'Mipo Admin',
            'first_name' => 'Mipo',
            'last_name' => 'Admin',
            'email' => 'admin@mipo.com',
            'password' => bcrypt('12121212'),
            'is_admin' => '1',
            'gender' => 'Male',
            'is_active' => '1',
            'created_by' => '1',
            'updated_by' => '1',
            'registered_at' => date('Y-m-d H:i:s'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        DB::table('roles')->insert([
            'slug' => PackageUuid::uuid4()->toString(),
            'name' => 'admin',
            'display_name' => 'Admin',
            'description' => 'Admin User',
            'is_active' => '1',
            'created_by' => '1',
            'updated_by' => '1',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            'deleted_at' => null
        ]);

        DB::table('role_user')->insert([
            'user_id' => '1',
            'role_id' => '1',
            'user_type' => 'App\Models\User',
        ]);
        
        // $this->call(CountrySeeder::class);
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        $this->call(UserLevelSeeder::class);
        $this->call(PlanSeeder::class);
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        $this->call(OperationProgressSeeder::class);
        $this->call(SettingsTableSeeder::class);
        $this->call(CompanyTypeSeeder::class);
        $this->call(LanguageSeeder::class);
        $this->call(FaqTypeSeeder::class);
        $this->call(HomeTextSeeder::class);
        $this->call(PermissionSeeder::class);
        $this->call(IssuerBanksSeeder::class);
        $this->call(PagesSeeder::class);
        $this->call(CitySeeder::class);
        $this->call(RolesAndPermissionsSeeder::class);
        $this->call(SettingsNotificationsSeeder::class);
    }
}
