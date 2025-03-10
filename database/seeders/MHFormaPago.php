<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MHFormaPago extends Seeder
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
                'valor' => 'Billetes y monedas',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '02',
                'valor' => 'Tarjeta Débito',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '03',
                'valor' => 'Tarjeta Crédito',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '04',
                'valor' => 'Cheque',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '05',
                'valor' => 'Transferencia-Depósito Bancario',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '08',
                'valor' => 'Dinero electrónico',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '09',
                'valor' => 'Monedero electrónico',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '11',
                'valor' => 'Bitcoin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '12',
                'valor' => 'Otras Criptomonedas',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '13',
                'valor' => 'Cuentas por pagar del receptor',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '14',
                'valor' => 'Giro bancario',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '99',
                'valor' => 'Otros (se debe indicar el medio de pago)',
                'created_at' => now(),
                'updated_at' => now(),
            ],

        ];

        DB::table('mh_forma_pago')->insert($values);
    }
}
