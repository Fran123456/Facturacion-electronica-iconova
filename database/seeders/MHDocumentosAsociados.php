<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MHDocumentosAsociados extends Seeder
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
                'valor' => 'Emisor',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '2',
                'valor' => 'Receptor',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '3',
                'valor' => 'Médico (solo aplica para contribuyentes obligados a la presentación de F-958)',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '4',
                'valor' => 'Transporte (solo aplica para Factura de exportación)',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        DB::table('mh_documentos_asociados')->insert($values);
    }
}
