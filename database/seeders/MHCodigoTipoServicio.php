<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MHCodigoTipoServicio extends Seeder
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
                'valor' => 'Cirugía',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '2',
                'valor' => 'Operación',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '3',
                'valor' => 'Tratamiento médico',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '4',
                'valor' => 'Cirugía Instituto Salvadoreño de Bienestar Magisterial',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '5',
                'valor' => 'Operación Instituto Salvadoreño de Bienestar Magisterial',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '6',
                'valor' => 'Tratamiento médico Instituto Salvadoreño de Bienestar Magisterial',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('mh_codigo_tipo_servicio_medico')->insert($values);
    }
}
