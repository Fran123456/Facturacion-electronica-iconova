<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MHCondicionOperacion extends Seeder
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
                'valor' => 'Contado',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '2',
                'valor' => 'A crédito',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '3',
                'valor' => 'Otro',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('mh_condicion_operacion')->insert($values);
    }
}
