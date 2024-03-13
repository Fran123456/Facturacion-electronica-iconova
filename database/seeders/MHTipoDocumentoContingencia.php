<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MHTipoDocumentoContingencia extends Seeder
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
                'valor' => 'Factura Electrónico',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '03',
                'valor' => 'Comprobante de Crédito Fiscal Electrónico',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '04',
                'valor' => 'Nota de Remisión Electrónica',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '05',
                'valor' => 'Nota de Crédito Electrónica',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '06',
                'valor' => 'Nota de Débito Electrónica',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '11',
                'valor' => 'Factura de Exportación Electrónica',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '14',
                'valor' => 'Factura de Sujeto Excluido Electrónica',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        DB::table('mh_tipo_documento_contingencia')->insert($values);
    }
}
