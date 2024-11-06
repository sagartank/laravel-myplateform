<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Ramsey\Uuid\Uuid as PackageUuid;
use Illuminate\Support\Facades\DB;
use App\Models\IssuerBank;

class IssuerBanksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('issuer_banks')->truncate();

        $issuer_banks = [
            [
                'slug' => PackageUuid::uuid4()->toString(),
                'name' => 'Banco Rio S.A.E.C.A',
            ],
            [
                'slug' => PackageUuid::uuid4()->toString(),
                'name' => 'Solar Banco S.A.E.',
            ],
            [
                'slug' => PackageUuid::uuid4()->toString(),
                'name' => 'Banco Nacional de Fomento (BNF)',
            ],
            [
                'slug' => PackageUuid::uuid4()->toString(),
                'name' => 'Interfisa Banco',
            ],
            [
                'slug' => PackageUuid::uuid4()->toString(),
                'name' => 'Banco Atlas S.A.',
            ],
            [
                'slug' => PackageUuid::uuid4()->toString(),
                'name' => 'BANCOP S.A.',
            ],
            [
                'slug' => PackageUuid::uuid4()->toString(),
                'name' => 'Visión Banco S.A.E.C.A.',
            ],
            [
                'slug' => PackageUuid::uuid4()->toString(),
                'name' => 'Sudameris Bank S.A.E.C.A.',
            ],
            [
                'slug' => PackageUuid::uuid4()->toString(),
                'name' => 'Banco GNB - Paraguay',
            ],
            [
                'slug' => PackageUuid::uuid4()->toString(),
                'name' => 'Banco Regional S.A.E.C.A.',
            ],
            [
                'slug' => PackageUuid::uuid4()->toString(),
                'name' => 'Banco Itaú Paraguay S.A.',
            ],
            [
                'slug' => PackageUuid::uuid4()->toString(),
                'name' => 'Banco Familiar S.A.E.C.A.',
            ],
            [
                'slug' => PackageUuid::uuid4()->toString(),
                'name' => 'Banco Continental S.A.E.C.A.',
            ],
            [
                'slug' => PackageUuid::uuid4()->toString(),
                'name' => 'Banco BASA',
            ],
            [
                'slug' => PackageUuid::uuid4()->toString(),
                'name' => 'Finexpar S.A.E.C.A.',
            ],
            [
                'slug' => PackageUuid::uuid4()->toString(),
                'name' => 'FIC S.A. de Finanzas',
            ],
            [
                'slug' => PackageUuid::uuid4()->toString(),
                'name' => 'Tu Financiera',
            ],
            [
                'slug' => PackageUuid::uuid4()->toString(),
                'name' => 'Financiera Paraguayo Japonesa S.A.E.C.A',
            ],
            [
                'slug' => PackageUuid::uuid4()->toString(),
                'name' => 'Financiera Ueno',
            ],
            [
                'slug' => PackageUuid::uuid4()->toString(),
                'name' => 'Cooperativa Alemán Concordia Ltda.',
            ],
            [
                'slug' => PackageUuid::uuid4()->toString(),
                'name' => 'Cooperativa Mborayhu Ltda.',
            ],
            [
                'slug' => PackageUuid::uuid4()->toString(),
                'name' => 'Cooperativa Nazareth Ltda.',
            ],
            [
                'slug' => PackageUuid::uuid4()->toString(),
                'name' => 'Cooperativa Coodeñe Ltda.',
            ],
            [
                'slug' => PackageUuid::uuid4()->toString(),
                'name' => 'Cooperativa Ñemby Ltda.',
            ],
            [
                'slug' => PackageUuid::uuid4()->toString(),
                'name' => 'Cooperativa Judicial Ltda.',
            ],
            [
                'slug' => PackageUuid::uuid4()->toString(),
                'name' => 'Cooperativa Mercado 4 Ltda.',
            ],
            [
                'slug' => PackageUuid::uuid4()->toString(),
                'name' => 'Cooperativa Multiactiva 8 de Marzo Ltda.',
            ],
            [
                'slug' => PackageUuid::uuid4()->toString(),
                'name' => 'Cooperativa Chortitzer Ltda.',
            ],
            [
                'slug' => PackageUuid::uuid4()->toString(),
                'name' => 'Cooperativa Neuland Ltda.',
            ],
            [
                'slug' => PackageUuid::uuid4()->toString(),
                'name' => 'Cooperativa Raúl Peña Ltda.',
            ],
            [
                'slug' => PackageUuid::uuid4()->toString(),
                'name' => 'Cooperativa Naranjal Ltda.',
            ],
            [
                'slug' => PackageUuid::uuid4()->toString(),
                'name' => 'Cooperativa Colonias Unidas Ltda.',
            ],
            [
                'slug' => PackageUuid::uuid4()->toString(),
                'name' => 'Cooperativa Fernheim Ltda.',
            ],
            [
                'slug' => PackageUuid::uuid4()->toString(),
                'name' => 'Cooperativa Ypacarai Ltda.',
            ],
            [
                'slug' => PackageUuid::uuid4()->toString(),
                'name' => 'Cooperativa San Juan Bautista Ltda.',
            ],
            [
                'slug' => PackageUuid::uuid4()->toString(),
                'name' => 'Cooperativa Universitaria Ltda.',
            ],
            [
                'slug' => PackageUuid::uuid4()->toString(),
                'name' => 'Cooperativa Coomecipar Ltda.',
            ],
            [
                'slug' => PackageUuid::uuid4()->toString(),
                'name' => 'COPACONS Ltda.',
            ],
            [
                'slug' => PackageUuid::uuid4()->toString(),
                'name' => 'Cooperativa Medalla Milagrosa Ltda.',
            ],
            [
                'slug' => PackageUuid::uuid4()->toString(),
                'name' => 'Cooperativa Mburicao Ltda.',
            ],
            [
                'slug' => PackageUuid::uuid4()->toString(),
                'name' => 'Cooperativa Lambaré Ltda.',
            ],
            [
                'slug' => PackageUuid::uuid4()->toString(),
                'name' => 'Cooperativa de las Fuerzas Armadas de la Nación Ltda.',
            ]
        ];

        IssuerBank::insert($issuer_banks);
    }
}
