<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MHTipoContingencia extends Seeder
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
                'valor' => 'No disponibilidad de sistema del MH',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '2',
                'valor' => 'No disponibilidad de sistema del emisor',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '3',
                'valor' => 'Falla en el suministro de servicio de Internet del Emisor que impida la transmisión de los DTE',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '4',
                'valor' => 'Falla en el suministro de servicio de energía eléctrica del emisor que impida la transmisión de los DTE',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '5',
                'valor' => 'Otro (deberá digitar un máximo de 500 caracteres explicando el motivo)',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('mh_tipo_contingencia')->insert($values);
    }
}
