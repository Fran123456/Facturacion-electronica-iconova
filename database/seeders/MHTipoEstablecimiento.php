<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MHTipoEstablecimiento extends Seeder
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
                'valor' => 'Sucursal / Agencia',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '02',
                'valor' => 'Casa matriz',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '04',
                'valor' => 'Bodega',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '07',
                'valor' => 'Predio y/o patio',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '20',
                'valor' => 'Otro',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('mh_tipo_establecimiento')->insert($values);
    }
}
