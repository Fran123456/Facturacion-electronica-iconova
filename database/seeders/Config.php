<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Config extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $values = [
            // [
            //     'titulo' => 'URL DEL FIRMADOR',
            //     'key_conf' => 'FIRMADOR_URL_BASE',
            //     'valor' => 'http://165.227.125.152:8113/',
            //     'created_at' => date('Y-m-d h:i:s'),
            //     'updated_at' => date('Y-m-d h:i:s'),
            // ],
            // [
            //     'titulo' => 'URL API MINISTERIO HACIENDA TEST',
            //     'key_conf' => 'URL_MH_DTES_TEST',
            //     'valor' => 'https://apitest.dtes.mh.gob.sv/',
            //     'created_at' => date('Y-m-d h:i:s'),
            //     'updated_at' => date('Y-m-d h:i:s'),
            // ],
            // [
            //     'titulo' => 'URL API MINISTERIO HACIENDA PROD',
            //     'key_conf' => 'URL_MH_DTES',
            //     'valor' => 'https://api.dtes.mh.gob.sv/',
            //     'created_at' => date('Y-m-d h:i:s'),
            //     'updated_at' => date('Y-m-d h:i:s'),
            // ],
            // [
            //     'titulo' => 'URL API MINISTERIO HACIENDA PROD',
            //     'key_conf' => 'URL_MH_DTES',
            //     'valor' => 'https://api.dtes.mh.gob.sv/',
            //     'created_at' => date('Y-m-d h:i:s'),
            //     'updated_at' => date('Y-m-d h:i:s'),
            // ],
            // [
            //     'titulo' => 'AMBIENTE API HACIENDA PRODUCCION',
            //     'key_conf' => 'AMBIENTE_API_MH_PRODUCCION',
            //     'valor' => '0',
            //     'created_at' => date('Y-m-d h:i:s'),
            //     'updated_at' => date('Y-m-d h:i:s'),
            // ],
            [
                'titulo' => 'FACTURA',
                'key_conf' => '01',
                'valor' => '0',
                'created_at' => date('Y-m-d h:i:s'),
                'updated_at' => date('Y-m-d h:i:s'),
            ],
            [
                'titulo' => 'CONTADOR CREDITO FISCAL',
                'key_conf' => '03',
                'valor' => '0',
                'created_at' => date('Y-m-d h:i:s'),
                'updated_at' => date('Y-m-d h:i:s'),
            ],
            [
                'titulo' => 'NOTA DE REMISION',
                'key_conf' => '04',
                'valor' => '0',
                'created_at' => date('Y-m-d h:i:s'),
                'updated_at' => date('Y-m-d h:i:s'),
            ],
            [
                'titulo' => 'NOTA DE CREDITO',
                'key_conf' => '05',
                'valor' => '0',
                'created_at' => date('Y-m-d h:i:s'),
                'updated_at' => date('Y-m-d h:i:s'),
            ],
            [
                'titulo' => 'NOTA DE DEBITO',
                'key_conf' => '06',
                'valor' => '0',
                'created_at' => date('Y-m-d h:i:s'),
                'updated_at' => date('Y-m-d h:i:s'),
            ],
            [
                'titulo' => 'COMPROBANTE DE RETENCION',
                'key_conf' => '07',
                'valor' => '0',
                'created_at' => date('Y-m-d h:i:s'),
                'updated_at' => date('Y-m-d h:i:s'),
            ],
            [
                'titulo' => 'COMPROBANTE DE LIQUIDACION',
                'key_conf' => '08',
                'valor' => '0',
                'created_at' => date('Y-m-d h:i:s'),
                'updated_at' => date('Y-m-d h:i:s'),
            ],
            [
                'titulo' => 'DOCUMENTO CONTABLE DE LIQUIDACION',
                'key_conf' => '09',
                'valor' => '0',
                'created_at' => date('Y-m-d h:i:s'),
                'updated_at' => date('Y-m-d h:i:s'),
            ],
            [
                'titulo' => 'FACTURAS DE EXPORTACION',
                'key_conf' => '11',
                'valor' => '0',
                'created_at' => date('Y-m-d h:i:s'),
                'updated_at' => date('Y-m-d h:i:s'),
            ],
            [
                'titulo' => 'FACTURAS DE SUJETO EXCLUIDO',
                'key_conf' => '14',
                'valor' => '0',
                'created_at' => date('Y-m-d h:i:s'),
                'updated_at' => date('Y-m-d h:i:s'),
            ],
            [
                'titulo' => 'COMPROBANTE DE DONACION',
                'key_conf' => '15',
                'valor' => '0',
                'created_at' => date('Y-m-d h:i:s'),
                'updated_at' => date('Y-m-d h:i:s'),
            ],
        ];

        DB::table('config')->insert($values);
    }
}
