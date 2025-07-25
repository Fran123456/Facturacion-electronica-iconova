<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MHPlazo extends Seeder
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
                'valor' => 'Días',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '02',
                'valor' => 'Meses',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '03',
                'valor' => 'Años',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('mh_plazo')->insert($values);
    }
}
