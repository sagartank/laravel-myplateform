<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $role = Role::create([
        //     'display_name' => 'NOOBIE',
        //     'name' => strtolower(str_replace(' ', '-', 'NOOBIE')),
        //     'is_for_user_level' => 1,
        //     'description' => 'Default permission added by seeder so please do not delete this.',
        // ]);
        $permissionIds = Permission::all()->pluck('id')->toArray();
        // Account Owner (NOOBIE)
        foreach(config('constants.DEFAULT_ROLES_FOR_USER_LEVELS') as $key=>$val){
            $role = Role::updateOrCreate(
                [ 'display_name' => $val,'name' => strtolower(str_replace(' ', '-', $val))],
                [ 'is_for_user_level' => 1,'description' => 'Default permission added by seeder so please do not delete this.']
            );
            $role->syncPermissions($permissionIds);
        }
        /*$role = Role::updateOrCreate(
            [ 'display_name' => 'NOOBIE','name' => strtolower(str_replace(' ', '-', 'NOOBIE'))],
            [ 'is_for_user_level' => 1,'description' => 'Default permission added by seeder so please do not delete this.']
        );
        /*$noobiePermissionAr = [
            74 ,75 ,76 ,77 ,78 ,80 ,32 ,81 ,82 ,83 ,84 ,86 ,87 ,88 ,115 ,116 ,117 ,118 ,119 ,120 ,121 ,144 ,145 ,146 ,147 ,148 ,149 ,150 ,151 ,155 ,156 ,157 ,158 ,171
        ];*/
        /*$role->syncPermissions($permissionIds);*/

        // Account Owner (Bronze)
        /*$roleBronze = Role::updateOrCreate(
            [ 'display_name' => 'Bronze','name' => strtolower(str_replace(' ', '-', 'Bronze'))],
            [ 'is_for_user_level' => 1,'description' => 'Default permission added by seeder so please do not delete this.']
        );
        /*$bronzePermissionAr = [
            74 ,75 ,76 ,77 ,78 ,79 ,80 ,31 ,32 ,81 , 82 , 83 , 84 , 85 , 86 , 87 , 88 , 115 , 116 , 117 , 118 , 119 , 120 , 121 , 144 , 145 , 146 , 147 , 148 , 149 , 150 , 151 , 152 , 154 , 155 , 156 , 157 , 158 , 171
        ];
        $roleB->syncPermissions($bronzePermissionAr);*/
        /*$roleBronze->syncPermissions($permissionIds);
        // Account Owner (Silver)
        $roleSilver = Role::updateOrCreate(
            [ 'display_name' => 'Silver','name' => strtolower(str_replace(' ', '-', 'Silver'))],
            [ 'is_for_user_level' => 1,'description' => 'Default permission added by seeder so please do not delete this.']
        );

        // Account Owner (Gold)
        $roleGold = Role::updateOrCreate(
            [ 'display_name' => 'Gold','name' => strtolower(str_replace(' ', '-', 'Gold'))],
            [ 'is_for_user_level' => 1,'description' => 'Default permission added by seeder so please do not delete this.']
        );
        $roleGold->syncPermissions($permissionIds);
        // Account Owner (Platinum)
        $rolePlatinum = Role::updateOrCreate(
            [ 'display_name' => 'Platinum','name' => strtolower(str_replace(' ', '-', 'Platinum'))],
            [ 'is_for_user_level' => 1,'description' => 'Default permission added by seeder so please do not delete this.']
        );
        $rolePlatinum->syncPermissions($permissionIds);
        // Account Owner (Enterprise)
        $roleEnterprise = Role::updateOrCreate(
            [ 'display_name' => 'Enterprise','name' => strtolower(str_replace(' ', '-', 'Enterprise'))],
            [ 'is_for_user_level' => 1,'description' => 'Default permission added by seeder so please do not delete this.']
        );
        $roleEnterprise->syncPermissions($permissionIds);*/
    }
}
