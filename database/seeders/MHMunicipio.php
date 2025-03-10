<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MHMunicipio extends Seeder
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
                'codigo' => '00',
                'valor' => 'Otro País',
                'departamento' => '00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Departamen            //^ AHUACHAPAN
            [
                'codigo' => '13',
                'valor' => 'AHUACHAPAN NORTE',
                'departamento' => '01',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '14',
                'valor' => 'AHUACHAPAN CENTRO',
                'departamento' => '01',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '15',
                'valor' => 'AHUACHAPAN SUR',
                'departamento' => '01',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            //^ SANTA ANA
            [
                'codigo' => '14',
                'valor' => 'SANTA ANA NORTE',
                'departamento' => '02',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '15',
                'valor' => 'SANTA ANA CENTRO',
                'departamento' => '02',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '16',
                'valor' => 'SANTA ANA ESTE',
                'departamento' => '02',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '17',
                'valor' => 'SANTA ANA OESTE',
                'departamento' => '02',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            //^ SONSONATE
            [
                'codigo' => '17',
                'valor' => 'SONSONATE NORTE',
                'departamento' => '03',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '18',
                'valor' => 'SONSONATE CENTRO',
                'departamento' => '03',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '19',
                'valor' => 'SONSONATE ESTE',
                'departamento' => '03',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '20',
                'valor' => 'SONSONATE OESTE',
                'departamento' => '03',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            //^ CHALATENANGO
            [
                'codigo' => '34',
                'valor' => 'CHALATENANGO NORTE',
                'departamento' => '04',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '35',
                'valor' => 'CHALATENANGO CENTRO',
                'departamento' => '04',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '36',
                'valor' => 'CHALATENANGO SUR',
                'departamento' => '04',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            //^ LA LIBERTAD
            [
                'codigo' => '23',
                'valor' => 'LA LIBERTAD NORTE',
                'departamento' => '05',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '24',
                'valor' => 'LA LIBERTAD CENTRO',
                'departamento' => '05',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '25',
                'valor' => 'LA LIBERTAD OESTE',
                'departamento' => '05',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '26',
                'valor' => 'LA LIBERTAD ESTE',
                'departamento' => '05',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '27',
                'valor' => 'LA LIBERTAD COSTA',
                'departamento' => '05',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '28',
                'valor' => 'LA LIBERTAD SUR',
                'departamento' => '05',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            //^ SAN SALVADOR
            [
                'codigo' => '20',
                'valor' => 'SAN SALVADOR NORTE',
                'departamento' => '06',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '21',
                'valor' => 'SAN SALVADOR OESTE',
                'departamento' => '06',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '22',
                'valor' => 'SAN SALVADOR ESTE',
                'departamento' => '06',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '23',
                'valor' => 'SAN SALVADOR CENTRO',
                'departamento' => '06',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '24',
                'valor' => 'SAN SALVADOR SUR',
                'departamento' => '06',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            //^ CUSCATLAN
            [
                'codigo' => '23',
                'valor' => 'CUSCATLAN NORTE',
                'departamento' => '07',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '24',
                'valor' => 'CUSCATLAN SUR',
                'departamento' => '07',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            //^ LA PAZ
            [
                'codigo' => '23',
                'valor' => 'LA PAZ OESTE',
                'departamento' => '08',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '24',
                'valor' => 'LA PAZ CENTRO',
                'departamento' => '08',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '25',
                'valor' => 'LA PAZ ESTE',
                'departamento' => '08',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            //^ CABAÑAS
            [
                'codigo' => '10',
                'valor' => 'CABAÑAS OESTE',
                'departamento' => '09',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '11',
                'valor' => 'CABAÑAS ESTE',
                'departamento' => '09',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            //^ SAN VICENTE
            [
                'codigo' => '14',
                'valor' => 'SAN VICENTE NORTE',
                'departamento' => '10',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '15',
                'valor' => 'SAN VICENTE SUR',
                'departamento' => '10',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            //^ USULUTAN
            [
                'codigo' => '24',
                'valor' => 'USULUTAN NORTE',
                'departamento' => '11',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '25',
                'valor' => 'USULUTAN ESTE',
                'departamento' => '11',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '26',
                'valor' => 'USULUTAN OESTE',
                'departamento' => '11',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            //^ SAN MIGUEL
            [
                'codigo' => '21',
                'valor' => 'SAN MIGUEL NORTE',
                'departamento' => '12',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '22',
                'valor' => 'SAN MIGUEL CENTRO',
                'departamento' => '12',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '23',
                'valor' => 'SAN MIGUEL OESTE',
                'departamento' => '12',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            //^ MORAZAN
            [
                'codigo' => '27',
                'valor' => 'MORAZAN NORTE',
                'departamento' => '13',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '28',
                'valor' => 'MORAZAN SUR',
                'departamento' => '13',
                'created_at' => now(),
                'updated_at' => now(),
            ],//^ LA UNION
            [
                'codigo' => '19',
                'valor' => 'LA UNION NORTE',
                'departamento' => '14',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '20',
                'valor' => 'LA UNION SUR',
                'departamento' => '14',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];
        DB::table('mh_municipio')->insert($values);
    }      
}