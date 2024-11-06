<?php

namespace Database\Seeders;

use App\Models\Language;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('languages')->truncate();

        $languages = [
            [
                'id'         => 1,
                'name'       => 'Czech',
                'short_code' => 'cs',
            ],
            [
                'id'         => 2,
                'name'       => 'Dutch',
                'short_code' => 'nl',
            ],
            [
                'id'         => 3,
                'name'       => 'English',
                'short_code' => 'en',
            ],
            [
                'id'         => 4,
                'name'       => 'French',
                'short_code' => 'fr',
            ],
            [
                'id'         => 5,
                'name'       => 'German',
                'short_code' => 'de',
            ],
            [
                'id'         => 6,
                'name'       => 'Greek',
                'short_code' => 'el',
            ],
            [
                'id'         => 7,
                'name'       => 'Hindi',
                'short_code' => 'hi',
            ],
            [
                'id'         => 8,
                'name'       => 'Italian',
                'short_code' => 'it',
            ],
            [
                'id'         => 9,
                'name'       => 'Japanese',
                'short_code' => 'jp',
            ],
            [
                'id'         => 10,
                'name'       => 'Portuguese',
                'short_code' => 'pt',
            ],
            [
                'id'         => 11,
                'name'       => 'Spanish',
                'short_code' => 'es',
            ],
        ];

        Language::insert($languages);
    }
}
