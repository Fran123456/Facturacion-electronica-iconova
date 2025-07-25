<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoCliente extends Seeder
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
                "tipo" => "pequeño contribuyente"
            ],
            [
                "tipo" => "mediano contribuyente"
            ],
            [
                "tipo" => "gran contribuyente"
            ],
        ];

        DB::table("tipo_cliente")->insert($values);
    }
}
