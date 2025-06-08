<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MHRetencionIVA extends Seeder
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
                'codigo' => '22',
                'valor' => 'Retención IVA 1%',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => 'C4',
                'valor' => 'Retención IVA 13%',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => 'C9',
                'valor' => 'Otras retenciones IVA casos especiales',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('mh_retencion_iva')->insert($values);
    }
}
