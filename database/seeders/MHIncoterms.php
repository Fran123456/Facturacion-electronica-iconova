<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MHIncoterms extends Seeder
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
                'valor' => 'EXW-En fábrica',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '02',
                'valor' => 'FCA-Libre transportista',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '03',
                'valor' => 'CPT-Transporte pagado hasta',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '04',
                'valor' => 'CIP-Transporte y seguro pagado hasta',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '05',
                'valor' => 'DAP-Entrega en el lugar',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '06',
                'valor' => 'DPU-Entregado en el lugar descargado',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '07',
                'valor' => 'DDP-Entrega con impuestos pagados',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '08',
                'valor' => 'FAS-Libre al costado del buque',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '09',
                'valor' => 'FOB-Libre a bordo',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '10',
                'valor' => 'CFR-Costo y flete',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '11',
                'valor' => 'CIF- Costo seguro y flete',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('mh_incoterms')->insert($values);
    }
}
