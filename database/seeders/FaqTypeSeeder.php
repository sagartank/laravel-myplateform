<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FaqTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('faq_types')->delete();
        DB::table('faqs')->delete();

        DB::insert(DB::raw("INSERT INTO `faq_types` (`id`, `slug`, `name`, `is_active`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
        (1, '366bcf1f-fcb1-4a01-a5f5-702be6975298', '{\"es\":\"General\",\"en\":\"General\"}', 1, 1, 1, '2023-01-28 13:34:33', '2023-01-28 13:34:33', NULL),
        (2, '63f09811-8df6-4b3b-9ef8-bd13295fd67c', '{\"es\":\"Prestatarios\",\"en\":\"Borrowers\"}', 1, 1, 1, '2023-01-28 13:34:53', '2023-01-28 13:45:47', NULL),
        (3, 'd63dcbd8-0c1e-46f3-97ea-3a54b547ff15', '{\"es\":\"Inversores\",\"en\":\"Investors\"}', 1, 1, 1, '2023-01-28 13:46:47', '2023-01-28 13:46:47', NULL),
        (4, 'a350b1d4-fc4a-46c0-a92c-ad2349c5be4d', '{\"es\":\"Operativa\",\"en\":\"Operational\"}', 1, 1, 1, '2023-01-28 13:47:09', '2023-01-28 13:47:09', NULL),
        (5, 'd9a5050a-a561-4631-a065-e896ed0e22a1', '{\"es\":\"Legal\",\"en\":\"Legal\"}', 1, 1, 1, '2023-01-28 13:47:19', '2023-01-28 13:47:19', NULL)"));
    }
}
