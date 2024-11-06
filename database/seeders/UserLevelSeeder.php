<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\UserLevel;
use Illuminate\Support\Facades\DB;
use App\Models\Role;
use App\Models\Permission;

class UserLevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('user_level')->truncate();

        $userLevels = [
            [
                'name' => 'Noobie',
                'number_of_deals' => 0,
                'amount_of_sales_pyg' => 0,
                'can_view_upto_amount_pyg' => 10000000,
            ],
            [
                'name' => 'Bronze',
                'number_of_deals' => 1,
                'amount_of_sales_pyg' => 15000000,
                'can_view_upto_amount_pyg' => 70000000,
            ],
            [
                'name' => 'Silver',
                'number_of_deals' => 11,
                'amount_of_sales_pyg' => 50000000,
                'can_view_upto_amount_pyg' => 250000000,
            ],
            [
                'name' => 'Gold',
                'number_of_deals' => 26,
                'amount_of_sales_pyg' => 100000000,
                'can_view_upto_amount_pyg' => 500000000,
            ],
            [
                'name' => 'Platinum',
                'number_of_deals' => 51,
                'amount_of_sales_pyg' => 500000000,
                'can_view_upto_amount_pyg' => null,
            ],
        ];
        $permissionIds = Permission::all()->pluck('id')->toArray();

        foreach ($userLevels as $userLevel) {
            UserLevel::create([
                'name' => $userLevel['name'],
                'number_of_deals' => $userLevel['number_of_deals'],
                'amount_of_sales_pyg' => $userLevel['amount_of_sales_pyg'],
                'can_view_upto_amount_pyg' => $userLevel['can_view_upto_amount_pyg'],
            ]);

            //Create role along with this user level to syn permission with this user level
            $role = Role::updateOrCreate(
                [ 'display_name' => $userLevel['name'],'name' => strtolower(str_replace(' ', '-', $userLevel['name']))],
                [ 'is_for_user_level' => 1,'description' => 'Default permission added by seeder so please do not delete this.']
            );
            $role->syncPermissions($permissionIds);
        }
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
