<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Plan;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Free plan
        DB::table('plans')->truncate();

        $free = Plan::updateOrCreate(
            [
                'name' => 'FREE',
                'slug' => Str::slug('FREE', '-'),
                'duration' => 'month'
            ],
            [           
                'price' => 0,
                'currency' => 'Gs.',
                'offer_price' => 0,
                'sort_order' => 1,
                'is_free_plan' => 1,
                'suitable_for_account_type' => 'Individual',
                'suitable_for_account_opener' => 'Borrower',
                'buy_sell' => 'yes',
                'basic_dashboard' => 'yes',
                'enterprise_dashboard' => 'no',
                'multi_user_account' => 0,
                'exportable_pdf' => 'no',
                'offer_notifications' => 'no',
                'legal_advice' => 'Payable',
                'monthly_reports' => 'no',
                'newsletters' => 'yes',
                'investor_commission' => 20,
                'user_level_id' => 1,
            ]
        );
        //ENTERPRISE 1
        Plan::updateOrCreate(
            [
                'name' => 'ENTERPRISE 1',
                'slug' => Str::slug('ENTERPRISE 1', '-'),
                'duration' => 'month'
            ],
            [
                'price' => 100000,
                'currency' => 'Gs.',
                'offer_price' => 100000,
                'sort_order' => 2,
                'is_free_plan' => 0,
                'suitable_for_account_type' => 'Enterprise',
                'suitable_for_account_opener' => 'Investor',
                'buy_sell' => 'yes',
                'basic_dashboard' => 'yes',
                'enterprise_dashboard' => 'yes',
                'multi_user_account' => 1,
                'exportable_pdf' => 'yes',
                'offer_notifications' => 'yes',
                'legal_advice' => 'Payable',
                'monthly_reports' => 'yes',
                'newsletters' => 'customizable',
                'investor_commission' => 15,
                'user_level_id' => 2,
            ]
        );
        //ENTERPRISE 2
        Plan::updateOrCreate(
            [
                'name' => 'ENTERPRISE 2',
                'slug' => Str::slug('ENTERPRISE 2', '-'),
                'duration' => 'month'
            ],
            [            
                'price' => 500000,
                'currency' => 'Gs.',
                'offer_price' => 500000,                
                'sort_order' => 3,
                'is_free_plan' => 0,
                'suitable_for_account_type' => 'Enterprise',
                'suitable_for_account_opener' => 'Investor',
                'buy_sell' => 'yes',
                'basic_dashboard' => 'yes',
                'enterprise_dashboard' => 'yes',
                'multi_user_account' => 4,
                'exportable_pdf' => 'yes',
                'offer_notifications' => 'yes',
                'legal_advice' => 'Payable',
                'monthly_reports' => 'yes',
                'newsletters' => 'customizable',
                'investor_commission' => 10,
                'user_level_id' => 3,
            ]
        );
        //ENTERPRISE 3
        Plan::updateOrCreate(
            [
                'name' => 'ENTERPRISE 3',
                'slug' => Str::slug('ENTERPRISE 3', '-'),
                'duration' => 'month',
            ],
            [
                'price' => 1000000,
                'currency' => 'Gs.',
                'offer_price' => 1000000,            
                'sort_order' => 4,
                'is_free_plan' => 0,
                'suitable_for_account_type' => 'Enterprise',
                'suitable_for_account_opener' => 'Investor',
                'buy_sell' => 'yes',
                'basic_dashboard' => 'yes',
                'enterprise_dashboard' => 'yes',
                'multi_user_account' => null,
                'exportable_pdf' => 'yes',
                'offer_notifications' => 'yes',
                'legal_advice' => 'free',
                'monthly_reports' => 'yes',
                'newsletters' => 'customizable',
                'investor_commission' => 5,
                'user_level_id' => 4,
            ]
        );
    }
}
