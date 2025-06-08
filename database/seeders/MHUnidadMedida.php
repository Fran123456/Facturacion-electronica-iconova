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
        $unidades = [
            ['codigo' => 13, 'valor' => 'metro cuadrado'],
            ['codigo' => 15, 'valor' => 'Vara cuadrada'],
            ['codigo' => 18, 'valor' => 'metro cúbico'],
            ['codigo' => 20, 'valor' => 'Barril'],
            ['codigo' => 22, 'valor' => 'Galón'],
            ['codigo' => 23, 'valor' => 'Litro'],
            ['codigo' => 24, 'valor' => 'Botella'],
            ['codigo' => 26, 'valor' => 'Mililitro'],
            ['codigo' => 30, 'valor' => 'Tonelada'],
            ['codigo' => 32, 'valor' => 'Quintal'],
            ['codigo' => 33, 'valor' => 'Arroba'],
            ['codigo' => 34, 'valor' => 'Kilogramo'],
            ['codigo' => 36, 'valor' => 'Libra'],
            ['codigo' => 37, 'valor' => 'Onza troy'],
            ['codigo' => 38, 'valor' => 'Onza'],
            ['codigo' => 39, 'valor' => 'Gramo'],
            ['codigo' => 40, 'valor' => 'Miligramo'],
            ['codigo' => 42, 'valor' => 'Megawatt'],
            ['codigo' => 43, 'valor' => 'Kilowatt'],
            ['codigo' => 44, 'valor' => 'Watt'],
            ['codigo' => 45, 'valor' => 'Megavoltio-amperio'],
            ['codigo' => 46, 'valor' => 'Kilovoltio-amperio'],
            ['codigo' => 47, 'valor' => 'Voltio-amperio'],
            ['codigo' => 49, 'valor' => 'Gigawatt-hora'],
            ['codigo' => 50, 'valor' => 'Megawatt-hora'],
            ['codigo' => 51, 'valor' => 'Kilowatt-hora'],
            ['codigo' => 52, 'valor' => 'Watt-hora'],
            ['codigo' => 53, 'valor' => 'Kilovoltio'],
            ['codigo' => 54, 'valor' => 'Voltio'],
            ['codigo' => 55, 'valor' => 'Millar'],
            ['codigo' => 56, 'valor' => 'Medio millar'],
            ['codigo' => 57, 'valor' => 'Ciento'],
            ['codigo' => 58, 'valor' => 'Docena'],
            ['codigo' => 59, 'valor' => 'Unidad'],
            ['codigo' => 99, 'valor' => 'Otra'],
        ];

        DB::table('mh_unidad_medida')->insert($unidades);
    }
}
