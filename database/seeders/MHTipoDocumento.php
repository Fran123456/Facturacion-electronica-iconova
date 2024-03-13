<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MHTipoDocumento extends Seeder
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
                'valor' => 'Factura',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '03',
                'valor' => 'Comprobante de crédito fiscal',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '04',
                'valor' => 'Nota de remisión',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '05',
                'valor' => 'Nota de crédito',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '06',
                'valor' => 'Nota de débito',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '07',
                'valor' => 'Comprobante de retención',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '08',
                'valor' => 'Comprobante de liquidación',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '09',
                'valor' => 'Documento contable de liquidación',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '11',
                'valor' => 'Facturas de exportación',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '14',
                'valor' => 'Factura de sujeto excluido',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '15',
                'valor' => 'Comprobante de donación',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('mh_tipo_documento')->insert($values);
    }
}
