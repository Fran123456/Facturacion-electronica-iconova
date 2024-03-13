<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MHUnidadMedida extends Seeder
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
                'valor' => 'Metro',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '02',
                'valor' => 'Yarda',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '03',
                'valor' => 'Vara',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '04',
                'valor' => 'Pie',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '05',
                'valor' => 'Pulgada',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '06',
                'valor' => 'Milímetro',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '08',
                'valor' => 'Milla cuadrada',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '09',
                'valor' => 'Kilómetro cuadrado',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '10',
                'valor' => 'Hectárea',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '11',
                'valor' => 'Manzana',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '12',
                'valor' => 'Acre',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '13',
                'valor' => 'Metro cuadrado',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '14',
                'valor' => 'Yarda cuadrada',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '15',
                'valor' => 'Vara cuadrada',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '16',
                'valor' => 'Pie cuadrado',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '17',
                'valor' => 'Pulgada cuadrada',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '18',
                'valor' => 'Metro cúbico',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '19',
                'valor' => 'Yarda cúbica',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '20',
                'valor' => 'Barril',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '21',
                'valor' => 'Pie cúbico',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '22',
                'valor' => 'Galón',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '23',
                'valor' => 'Litro',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '24',
                'valor' => 'Botella',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '25',
                'valor' => 'Pulgada cúbica',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '26',
                'valor' => 'Mililitro',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '27',
                'valor' => 'Onza fluida',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '29',
                'valor' => 'Tonelada métrica',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '30',
                'valor' => 'Tonelada',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '31',
                'valor' => 'Quintal métrico',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '32',
                'valor' => 'Quintal',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '33',
                'valor' => 'Arroba',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '34',
                'valor' => 'Kilogramo',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '35',
                'valor' => 'Libra troy',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '36',
                'valor' => 'Libra',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '37',
                'valor' => 'Onza troy',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '38',
                'valor' => 'Onza',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '39',
                'valor' => 'Gramo',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '40',
                'valor' => 'Miligramo',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '42',
                'valor' => 'Megawatt',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '43',
                'valor' => 'Kilowatt',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '44',
                'valor' => 'Watt',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '45',
                'valor' => 'Megavoltio-amperio',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '46',
                'valor' => 'Kilovoltio-amperio',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '47',
                'valor' => 'Voltio-amperio',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '49',
                'valor' => 'Gigawatt-hora',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '50',
                'valor' => 'Megawatt-hora',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '51',
                'valor' => 'Kilowatt-hora',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '52',
                'valor' => 'Watt-hora',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '53',
                'valor' => 'Kilovoltio',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '54',
                'valor' => 'Voltio',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '55',
                'valor' => 'Millar',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '56',
                'valor' => 'Medio millar',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '57',
                'valor' => 'Ciento',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '58',
                'valor' => 'Docena',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '59',
                'valor' => 'Unidad',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '99',
                'valor' => 'Otra',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('mh_unidad_medida')->insert($values);
    }
}
