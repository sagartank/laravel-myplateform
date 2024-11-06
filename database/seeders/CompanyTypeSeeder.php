<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Company;
use Ramsey\Uuid\Uuid as PackageUuid;
use Illuminate\Support\Facades\DB;

class CompanyTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('companies')->truncate();

        $companies = [
            [
                'slug' => PackageUuid::uuid4()->toString(),
                'name' => 'SA',
                'is_active' => '1',
            ],
            [
                'slug' => PackageUuid::uuid4()->toString(),
                'name' => 'LLP',
                'is_active' => '1',
            ],
            [
                'slug' => PackageUuid::uuid4()->toString(),
                'name' => 'PVT LTD',
                'is_active' => '1',
            ]
        ];

        Company::insert($companies);
    }
}
