<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MHTransporte extends Seeder
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
                'valor' => 'Terrestre',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '3',
                'valor' => 'Marítimo',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '2',
                'valor' => 'Aéreo',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '4',
                'valor' => 'FERREO',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '5',
                'valor' => 'MULTIMODAL',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '6',
                'valor' => 'CORREO',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            
        ];

        DB::table('mh_transporte')->insert($values);
    }
}
