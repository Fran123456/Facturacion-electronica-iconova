<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MHTipoItem extends Seeder
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
                'codigo' => '1',
                'valor' => 'Bienes',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '2',
                'valor' => 'Servicios',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '3',
                'valor' => 'Ambos (Bienes y Servicios, incluye los dos inherente a los Productos o servicios)',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '4',
                'valor' => 'Otros tributos por ítem',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('mh_tipo_item')->insert($values);
    }
}
