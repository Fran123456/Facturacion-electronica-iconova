<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MHDepartamento extends Seeder
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
                'codigo' => '00',
                'valor' => 'Otro',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '01',
                'valor' => 'Ahuachapán',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '02',
                'valor' => 'Santa Ana',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '03',
                'valor' => 'Sonsonate',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '04',
                'valor' => 'Chalatenango',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '05',
                'valor' => 'La Libertad',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '06',
                'valor' => 'San Salvador',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '07',
                'valor' => 'Cuscatlán',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '08',
                'valor' => 'La Paz',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '09',
                'valor' => 'Cabañas',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '10',
                'valor' => 'San Vicente',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '11',
                'valor' => 'Usulután',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '12',
                'valor' => 'San Miguel',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '13',
                'valor' => 'Morazán',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '14',
                'valor' => 'La Unión',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('mh_departamento')->insert($values);
    }
}
