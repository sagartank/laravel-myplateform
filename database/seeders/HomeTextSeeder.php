<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HomeTextSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('home_texts')->truncate();
        
        DB::insert(DB::raw("INSERT INTO `home_texts` (`id`, `slug`, `heading_text`, `sub_heading_text`, `footer_text`, `contact_email`, `contact_phone`, `address_line_1`, `address_line_2`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
        (1, '7d700648-9ed8-40d3-8059-090c18981d5c', '{\"es\":\"Financial Service for Buyer & Sellers\",\"en\":\"Financial Service for Buyer & Sellers\"}', '{\"es\":\"Aenean blandit dolor sit amet turpis placerat, quis tincidunt dolor suscipit.\",\"en\":\"Aenean blandit dolor sit amet turpis placerat, quis tincidunt dolor suscipit.\"}', '{\"es\":\"Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s\",\"en\":\"Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s\"}', 'demo@gmail.com', '+1123456789', '401-Street, Asunción,', 'Paraguay', NULL, NULL, NULL, NULL, NULL)"));
    }
}
