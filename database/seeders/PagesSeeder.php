<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Ramsey\Uuid\Uuid as PackageUuid;
use Illuminate\Support\Facades\DB;
use App\Models\Page;

class PagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('pages')->truncate();

        $pages = [
            [
                'slug' => PackageUuid::uuid4()->toString(),
                'name' => 'privacy-policy',
                'description' => '',
                'default_page' => 'Yes',
                'is_active' => 'Yes',
            ],
        ];

        Page::insert($pages);
    }
}
