<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MHRegimen extends Seeder
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
                'codigo' => 'EX1.1000.000',
                'valor' => 'Exportación Definitiva, Régimen Común'
            ],

            [
                'codigo' => 'EX1.1040.000',
                'valor' => 'Exportación Definitiva Sustitución de Mercancías, Régimen Común'
            ],

            [
                'codigo' => 'EX1.1041.020',
                'valor' => 'Franq. Presidenciales exento de DAI'
            ],

            [
                'codigo' => 'EX1.1041.021',
                'valor' => 'Franq. Presidenciales exento de DAI e IVA'
            ],

            [
                'codigo' => 'EX1.1048.025',
                'valor' => 'Maquinaria y Equipo LZF. DPA'
            ],

            [
                'codigo' => 'EX1.1048.031',
                'valor' => 'Distribución Internacional'
            ],

            [
                'codigo' => 'EX1.1048.032',
                'valor' => 'Operaciones Internacionales de Logística'
            ],

            [
                'codigo' => 'EX1.1048.033',
                'valor' => 'Centro Internacional de llamadas (Call Center)'
            ],

            [
                'codigo' => 'EX1.1048.034',
                'valor' => 'Tecnologías de Información LSI'
            ],

            [
                'codigo' => 'EX1.1048.035',
                'valor' => 'Investigación y Desarrollo LSI'
            ],
            [
                'codigo' => 'EX1.1048.036',
                'valor' => 'Exportación Definitiva Proveniente de Franquicia Definitiva, Reparación y Mantenimiento de Embarcaciones Marítimas LSI'
            ],
            [
                'codigo' => 'EX1.1048.037',
                'valor' => 'Exportación Definitiva Proveniente de Franquicia Definitiva, Reparación y Mantenimiento de Aeronaves LSI'
            ],
            [
                'codigo' => 'EX1.1048.038',
                'valor' => 'Exportación Definitiva Proveniente de Franquicia Definitiva, Procesos Empresariales LSI'
            ],
            [
                'codigo' => 'EX1.1048.039',
                'valor' => 'Exportación Definitiva Proveniente de Franquicia Definitiva, Servicios Medico-Hospitalarios LSI'
            ],
            [
                'codigo' => 'EX1.1048.040',
                'valor' => 'Exportación Definitiva Proveniente de Franquicia Definitiva, Servicios Financieros Internacionales LSI'
            ],
            [
                'codigo' => 'EX1.1048.043',
                'valor' => 'Exportación Definitiva Proveniente de Franquicia Definitiva, Reparación y Mantenimiento de Contenedores LSI'
            ],
            [
                'codigo' => 'EX1.1048.044',
                'valor' => 'Exportación Definitiva Proveniente de Franquicia Definitiva, Reparación de Equipos Tecnológicos LSI'
            ],
            [
                'codigo' => 'EX1.1048.054',
                'valor' => 'Exportación Definitiva Proveniente de Franquicia Definitiva, Atención Ancianos y Convalecientes LSI'
            ],
            [
                'codigo' => 'EX1.1048.055',
                'valor' => 'Exportación Definitiva Proveniente de Franquicia Definitiva, Telemedicina LSI'
            ],
            [
                'codigo' => 'EX1.1048.056',
                'valor' => 'Exportación Definitiva Proveniente de Franquicia Definitiva, Cinematografía LSI'
            ],
            [
                'codigo' => 'EX1.1052.000',
                'valor' => 'Exportación Definitiva de DPA con origen en Compras Locales, Régimen Común'
            ],
            [
                'codigo' => 'EX1.1054.000',
                'valor' => 'Exportación Definitiva de Zona Franca con origen en Compras Locales, Régimen Común'
            ],
            [
                'codigo' => 'EX1.1100.000',
                'valor' => 'Exportación Definitiva de Envíos de Socorro, Régimen Común'
            ],
            [
                'codigo' => 'EX1.1200.000',
                'valor' => 'Exportación Definitiva de Envíos Postales, Régimen Común'
            ],
            [
                'codigo' => 'EX1.1300.000',
                'valor' => 'Exportación Definitiva Envíos que requieren despacho urgente, Régimen Común'
            ],
            [
                'codigo' => 'EX1.1400.000',
                'valor' => 'Exportación Definitiva Courier, Régimen Común'
            ],
            [
                'codigo' => 'EX1.1400.011',
                'valor' => 'Exportación Definitiva Courier, Muestras Sin Valor Comercial'
            ],
            [
                'codigo' => 'EX1.1400.012',
                'valor' => 'Exportación Definitiva Courier, Material Publicitario'
            ],
            [
                'codigo' => 'EX1.1400.017',
                'valor' => 'Exportación Definitiva Courier, Declaración de Documentos'
            ],
            [
                'codigo' => 'EX1.1500.000',
                'valor' => 'Exportación Definitiva Menaje de casa, Régimen Común'
            ],
            [
                'codigo' => 'EX2.2100.000',
                'valor' => 'Exportación Temporal para Perfeccionamiento Pasivo, Régimen Común'
            ],
            [
                'codigo' => 'EX2.2200.000',
                'valor' => 'Exportación Temporal con Reimportación en el mismo estado, Régimen Común'
            ],
            [
                'codigo' => 'EX3.3050.000',
                'valor' => 'Reexportación Proveniente de Importación Temporal, Régimen Común'
            ],
            [
                'codigo' => 'EX3.3051.000',
                'valor' => 'Reexportación Proveniente de Tiendas Libres, Régimen Común'
            ],
            [
                'codigo' => 'EX3.3052.000',
                'valor' => 'Reexportación Proveniente de Admisión Temporal para Perfeccionamiento Activo, Régimen Común'
            ],
            [
                'codigo' => 'EX3.3053.000',
                'valor' => 'Reexportación Proveniente de Admisión Temporal, Régimen Común'
            ],
            [
                'codigo' => 'EX3.3054.000',
                'valor' => 'Reexportación Proveniente de Régimen de Zona Franca, Régimen Común'
            ],
            [
                'codigo' => 'EX3.3055.000',
                'valor' => 'Reexportación Proveniente de Admisión Temporal para Perfeccionamiento Activo con Garantía, Régimen Común'
            ],
            ['codigo' => 'EX3.3056.000', 'valor' => 'Reexportación Proveniente de Admisión Temporal Distribución Internacional Parque de Servicios, Régimen Común'],
            [
                'codigo' => 'EX3.3056.057',
                'valor' => 'Reexportación Proveniente de Admisión Temporal Distribución Internacional Parque de Servicios, Remisión entre Usuarios Directos del Mismo Parque de Servicios'
            ],
            [
                'codigo' => 'EX3.3056.058',
                'valor' => 'Reexportación Proveniente de Admisión Temporal Distribución Internacional Parque de Servicios, Remisión entre Usuarios Directos de Diferente Parque de Servicios'
            ],
            [
                'codigo' => 'EX3.3056.072',
                'valor' => 'Reexportación Proveniente de Admisión Temporal Distribución Internacional Parque de Servicios, Decreto 738 Eléctricos e Híbridos'
            ],
            [
                'codigo' => 'EX3.3057.000',
                'valor' => 'Reexportación Proveniente de Admisión Temporal Operaciones Internacional de Logística Parque de Servicios, Régimen Común'
            ],
            [
                'codigo' => 'EX3.3057.057',
                'valor' => 'Reexportación Proveniente de Admisión Temporal Operaciones Internacional de Logística Parque de Servicios, Remisión entre Usuarios Directos del Mismo Parque de Servicios'
            ],
            [
                'codigo' => 'EX3.3057.058',
                'valor' => 'Reexportación Proveniente de Admisión Temporal Operaciones Internacional de Logística Parque de Servicios, Remisión entre Usuarios Directos de Diferente Parque de Servicios'
            ],
            [
                'codigo' => 'EX3.3058.033',
                'valor' => 'Reexportación Proveniente de Admisión Temporal Centro Servicio LSI, Centro Internacional de llamadas (Call Center)'
            ],
            [
                'codigo' => 'EX3.3058.036',
                'valor' => 'Reexportación Proveniente de Admisión Temporal Centro Servicio LSI, Reparación y Mantenimiento de Embarcaciones Marítimas LSI'
            ],
            [
                'codigo' => 'EX3.3058.037',
                'valor' => 'Reexportación Proveniente de Admisión Temporal Centro Servicio LSI, Reparación y Mantenimiento de Aeronaves LSI'
            ],
            [
                'codigo' => 'EX3.3058.043',
                'valor' => 'Reexportación Proveniente de Admisión Temporal Centro Servicio LSI, Reparación y Mantenimiento de Contenedores LSI'
            ],
            [
                'codigo' => 'EX3.3059.000',
                'valor' => 'Reexportación Proveniente de Admisión Temporal Reparación de Equipo Tecnológico Parque de Servicios, Régimen Común'
            ],
            [
                'codigo' => 'EX3.3059.057',
                'valor' => 'Reexportación Proveniente de Admisión Temporal Reparación de Equipo Tecnológico Parque de Servicios, Remisión entre Usuarios Directos del Mismo Parque de Servicios'
            ],
            [
                'codigo' => 'EX3.3059.058',
                'valor' => 'Reexportación Proveniente de Admisión Temporal Reparación de Equipo Tecnológico Parque de Servicios, Remisión entre Usuarios Directos de Diferente Parque de Servicios'
            ],
            [
                'codigo' => 'EX3.3070.000',
                'valor' => 'Reexportación Proveniente de Depósito, Régimen Común'
            ],
            [
                'codigo' => 'EX3.3070.072',
                'valor' => 'Reexportación Proveniente de Depósito, Decreto 738 Eléctricos e Híbridos'
            ],
            //^ NUEVOS
            [
                'codigo' => 'EX3.3071.000',
                'valor' => 'Re-Exportación. Prov. de Deposito'
            ],
            [
                'codigo' => 'EX3.3072.000',
                'valor' => 'Re-Exportación. Prov. de Adm Temp. para Perfeccionamiento Activo'
            ],
            [
                'codigo' => 'EX3.3074.000',
                'valor' => 'Re-Exportación. Prov. de Regimen de Zona Franca'
            ],
            [
                'codigo' => 'EX3.3075.000',
                'valor' => 'Re-Exportación. Prov. de Adm. Temporal para Perfeccionamiento Activo con Garantía'
            ],
            [
                'codigo' => 'EX3.3076.000',
                'valor' => 'Re-Exportación. Prov. de Adm. Temporal ley de Servi. Internacionales'
            ],
            [
                'codigo' => 'EX3.3077.000',
                'valor' => 'Re-Exportación. Prov. de Centro de Servicio LSI'
            ],
        ];

        DB::table('mh_regimen')->insert($values);
    }
}
