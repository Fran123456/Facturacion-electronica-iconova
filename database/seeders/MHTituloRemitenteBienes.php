<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MHTituloRemitenteBienes extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $values = [
            [
                'codigo' => '01',
                'valor' => 'Depósito',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '02',
                'valor' => 'Propiedad',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '03',
                'valor' => 'Consignación',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '04',
                'valor' => 'Traslado',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '05',
                'valor' => 'Otros',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        DB::table('mh_titulo_remitente_bienes')->insert($values);
    }
}
