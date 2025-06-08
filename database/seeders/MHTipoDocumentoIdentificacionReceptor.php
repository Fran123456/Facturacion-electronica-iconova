<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MHTipoDocumentoIdentificacionReceptor extends Seeder
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
                'codigo' => '36',
                'valor' => 'NIT',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '13',
                'valor' => 'DUI',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '37',
                'valor' => 'Otro',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '03',
                'valor' => 'Pasaporte',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '02',
                'valor' => 'Carnet de Residente',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        DB::table('mh_tipo_documento_identificacion_receptor')->insert($values);
    }
}
