<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Settings;
use Ramsey\Uuid\Uuid as PackageUuid;
use Illuminate\Support\Facades\DB;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('settings')->truncate();

        $setting = [
            'id' => 1,
            'slug' =>  PackageUuid::uuid4()->toString(),
            'day_hour' => 0,
            'mipo_commission' => 0,
            'mipo_payment_commission' => 0,
            'account_selection_en' => 'Personalize the Start Menu
                Search In Windows 10 Quickly and Easily
                Use Focus Assist to Keep You On-Task
                Use Multiple Virtual Desktops To Manage Projects
                Securing Your Windows 10 Machine',
            'account_selection_es' => 'Personaliza el menú de inicio
            Buscar en Windows 10 de forma rápida y sencilla
            Use Focus Assist para mantenerse concentrado en la tarea
            Use múltiples escritorios virtuales para administrar proyectos
            Protección de su máquina con Windows 10',
        ];

        Settings::create($setting);
    }
}
