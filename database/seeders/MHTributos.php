<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MHTributos extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $values = [
            // Tributos Aplicados por Ítem
            [
                'codigo' => '20',
                'valor' => 'Impuesto al Valor Agregado 13%',
                'tipo' => 'Tributos aplicados por ítems reflejados en el resumen del DTE',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => 'C3',
                'valor' => 'Impuesto al Valor Agregado (exportaciones) 0%',
                'tipo' => 'Tributos aplicados por ítems reflejados en el resumen del DTE',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '59',
                'valor' => 'Turismo: por alojamiento (5%)',
                'tipo' => 'Tributos aplicados por ítems reflejados en el resumen del DTE',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '71',
                'valor' => 'Turismo: salida del país por vía aérea $7.00',
                'tipo' => 'Tributos aplicados por ítems reflejados en el resumen del DTE',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => 'D1',
                'valor' => 'FOVIAL ($0.20 Ctvs. por galón)',
                'tipo' => 'Tributos aplicados por ítems reflejados en el resumen del DTE',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => 'C8',
                'valor' => 'COTRANS ($0.10 Ctvs. por galón)',
                'tipo' => 'Tributos aplicados por ítems reflejados en el resumen del DTE',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => 'D5',
                'valor' => 'Otras tasas casos especiales',
                'tipo' => 'Tributos aplicados por ítems reflejados en el resumen del DTE',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => 'D4',
                'valor' => 'Otros impuestos casos especiales',
                'tipo' => 'Tributos aplicados por ítems reflejados en el resumen del DTE',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Tributo aplicado por item reflajados en el cuerpo
            [
                'codigo' => 'A8',
                'valor' => 'Impuesto Especial al Combustible (0%, 0.5%, 1%)',
                'tipo' => 'Tributos aplicados por ítems reflejados en el cuerpo del documento',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '57',
                'valor' => 'Impuesto industria de Cemento',
                'tipo' => 'Tributos aplicados por ítems reflejados en el cuerpo del documento',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '90',
                'valor' => 'Impuesto especial a la primera matrícula',
                'tipo' => 'Tributos aplicados por ítems reflejados en el cuerpo del documento',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => 'D4',
                'valor' => 'Otros impuestos casos especiales',
                'tipo' => 'Tributos aplicados por ítems reflejados en el cuerpo del documento',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => 'D5',
                'valor' => 'Otras tasas casos especiales',
                'tipo' => 'Tributos aplicados por ítems reflejados en el cuerpo del documento',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => 'A6',
                'valor' => 'Impuesto ad- valorem, armas de fuego, municiones explosivas y artículos similares',
                'tipo' => 'Tributos aplicados por ítems reflejados en el cuerpo del documento',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Impuestos Ad-Valorem
            [
                'codigo' => 'C5',
                'valor' => 'Impuesto ad-valorem por diferencial de precios de bebidas alcohólicas (8%)',
                'tipo' => 'Impuestos ad-valorem aplicados por ítem de uso informativo reflejados en el resumen del documento',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => 'C6',
                'valor' => 'Impuesto ad-valorem por diferencial de precios al tabaco cigarrillos (39%)',
                'tipo' => 'Impuestos ad-valorem aplicados por ítem de uso informativo reflejados en el resumen del documento',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => 'C7',
                'valor' => 'Impuesto ad-valorem por diferencial de precios al tabaco cigarros (100%)',
                'tipo' => 'Impuestos ad-valorem aplicados por ítem de uso informativo reflejados en el resumen del documento',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '19',
                'valor' => 'Fabricante de Bebidas Gaseosas, Isotónicas, Deportivas, Fortificantes, Energizante o Estimulante',
                'tipo' => 'Impuestos ad-valorem aplicados por ítem de uso informativo reflejados en el resumen del documento',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '28',
                'valor' => 'Importador de Bebidas Gaseosas, Isotónicas, Deportivas, Fortificantes, Energizante o Estimulante',
                'tipo' => 'Impuestos ad-valorem aplicados por ítem de uso informativo reflejados en el resumen del documento',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '31',
                'valor' => 'Detallistas o Expendedores de Bebidas Alcohólicas',
                'tipo' => 'Impuestos ad-valorem aplicados por ítem de uso informativo reflejados en el resumen del documento',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '32',
                'valor' => 'Fabricante de Cerveza',
                'tipo' => 'Impuestos ad-valorem aplicados por ítem de uso informativo reflejados en el resumen del documento',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '33',
                'valor' => 'Importador de Cerveza',
                'tipo' => 'Impuestos ad-valorem aplicados por ítem de uso informativo reflejados en el resumen del documento',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '34',
                'valor' => 'Fabricante de Productos de Tabaco',
                'tipo' => 'Impuestos ad-valorem aplicados por ítem de uso informativo reflejados en el resumen del documento',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '35',
                'valor' => 'Importador de Productos de Tabaco',
                'tipo' => 'Impuestos ad-valorem aplicados por ítem de uso informativo reflejados en el resumen del documento',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '36',
                'valor' => 'Fabricante de Armas de Fuego, Municiones y Artículos Similares',
                'tipo' => 'Impuestos ad-valorem aplicados por ítem de uso informativo reflejados en el resumen del documento',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '37',
                'valor' => 'Importador de Arma de Fuego, Munición y Artículos. Similares',
                'tipo' => 'Impuestos ad-valorem aplicados por ítem de uso informativo reflejados en el resumen del documento',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '38',
                'valor' => 'Fabricante de Explosivos',
                'tipo' => 'Impuestos ad-valorem aplicados por ítem de uso informativo reflejados en el resumen del documento',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '39',
                'valor' => 'Importador de Explosivos',
                'tipo' => 'Impuestos ad-valorem aplicados por ítem de uso informativo reflejados en el resumen del documento',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '42',
                'valor' => 'Fabricante de Productos Pirotécnicos',
                'tipo' => 'Impuestos ad-valorem aplicados por ítem de uso informativo reflejados en el resumen del documento',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '43',
                'valor' => 'Importador de Productos Pirotécnicos',
                'tipo' => 'Impuestos ad-valorem aplicados por ítem de uso informativo reflejados en el resumen del documento',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '44',
                'valor' => 'Productor de Tabaco',
                'tipo' => 'Impuestos ad-valorem aplicados por ítem de uso informativo reflejados en el resumen del documento',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '50',
                'valor' => 'Distribuidor de Bebidas Gaseosas, Isotónicas, Deportivas, Fortificantes, Energizante o Estimulante',
                'tipo' => 'Impuestos ad-valorem aplicados por ítem de uso informativo reflejados en el resumen del documento',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '51',
                'valor' => 'Bebidas Alcohólicas',
                'tipo' => 'Impuestos ad-valorem aplicados por ítem de uso informativo reflejados en el resumen del documento',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '52',
                'valor' => 'Cerveza',
                'tipo' => 'Impuestos ad-valorem aplicados por ítem de uso informativo reflejados en el resumen del documento',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '53',
                'valor' => 'Productos del Tabaco',
                'tipo' => 'Impuestos ad-valorem aplicados por ítem de uso informativo reflejados en el resumen del documento',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '54',
                'valor' => 'Bebidas Carbonatadas o Gaseosas Simples o Endulzadas',
                'tipo' => 'Impuestos ad-valorem aplicados por ítem de uso informativo reflejados en el resumen del documento',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '55',
                'valor' => 'Otros Específicos',
                'tipo' => 'Impuestos ad-valorem aplicados por ítem de uso informativo reflejados en el resumen del documento',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '58',
                'valor' => 'Alcohol',
                'tipo' => 'Impuestos ad-valorem aplicados por ítem de uso informativo reflejados en el resumen del documento',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '77',
                'valor' => 'Importador de Jugos, Néctares, Bebidas con Jugo y Refrescos',
                'tipo' => 'Impuestos ad-valorem aplicados por ítem de uso informativo reflejados en el resumen del documento',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '78',
                'valor' => 'Distribuidor de Jugos, Néctares, Bebidas con Jugo y Refrescos',
                'tipo' => 'Impuestos ad-valorem aplicados por ítem de uso informativo reflejados en el resumen del documento',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '79',
                'valor' => 'Sobre Llamadas Telefónicas Provenientes del Ext.',
                'tipo' => 'Impuestos ad-valorem aplicados por ítem de uso informativo reflejados en el resumen del documento',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '85',
                'valor' => 'Detallista de Jugos, Néctares, Bebidas con Jugo y Refrescos',
                'tipo' => 'Impuestos ad-valorem aplicados por ítem de uso informativo reflejados en el resumen del documento',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '86',
                'valor' => 'Fabricante de Preparaciones Concentradas o en Polvo para la Elaboración de Bebidas',
                'tipo' => 'Impuestos ad-valorem aplicados por ítem de uso informativo reflejados en el resumen del documento',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '91',
                'valor' => 'Fabricante de Jugos, Néctares, Bebidas con Jugo y Refrescos',
                'tipo' => 'Impuestos ad-valorem aplicados por ítem de uso informativo reflejados en el resumen del documento',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '92',
                'valor' => 'Importador de Preparaciones Concentradas o en Polvo para la Elaboración de Bebidas',
                'tipo' => 'Impuestos ad-valorem aplicados por ítem de uso informativo reflejados en el resumen del documento',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => 'A1',
                'valor' => 'Específicos y Ad-Valorem',
                'tipo' => 'Impuestos ad-valorem aplicados por ítem de uso informativo reflejados en el resumen del documento',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => 'A5',
                'valor' => 'Bebidas Gaseosas, Isotónicas, Deportivas, Fortificantes, Energizantes o Estimulantes',
                'tipo' => 'Impuestos ad-valorem aplicados por ítem de uso informativo reflejados en el resumen del documento',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => 'A7',
                'valor' => 'Alcohol Etílico',
                'tipo' => 'Impuestos ad-valorem aplicados por ítem de uso informativo reflejados en el resumen del documento',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => 'A9',
                'valor' => 'Sacos Sintéticos',
                'tipo' => 'Impuestos ad-valorem aplicados por ítem de uso informativo reflejados en el resumen del documento',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('mh_tributo')->insert($values);
    }
}
