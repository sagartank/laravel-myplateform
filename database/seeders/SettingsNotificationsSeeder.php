<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Ramsey\Uuid\Uuid as PackageUuid;
use Illuminate\Support\Facades\DB;
use App\Models\SettingsNotifications;

class SettingsNotificationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        DB::table('settings_notifications')->truncate();

        $settings_notifications = [
            [
                'notification_type' => 'OFFERS',
                'notification_title' => 'Offers Notification',
                'is_active' => 'Yes',
                'created_by' => '1',
                'updated_by' => '1',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'notification_type' => 'OPERATIONS',
                'notification_title' => 'Operations Notification',
                'is_active' => 'Yes',
                'created_by' => '1',
                'updated_by' => '1',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'notification_type' => 'OPERATIONS',
                'notification_title' => 'Operations Update Notification',
                'is_active' => 'Yes',
                'created_by' => '1',
                'updated_by' => '1',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'notification_type' => 'PROMOTIONAL',
                'notification_title' => 'Promotional Notification',
                'is_active' => 'Yes',
                'created_by' => '1',
                'updated_by' => '1',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
        ];

        SettingsNotifications::insert($settings_notifications);
    }
}
