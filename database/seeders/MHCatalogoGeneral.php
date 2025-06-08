<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MHCatalogoGeneral extends Seeder
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
                'campo' => 'CAT-001',
                'catalogo' => 'Ambiente de destino',
                'descripcion' => 'Contiene los códigos asignados por la Administración Tributaria para el Ambiente de Destino en el que se transmite el DTE. Los ambientes de Destino que este Catálogo posee son dos: Prueba y Producción.',
                'tipo' => 'FE, CCFE, NRE, NCE, NDE, CRE, CLE, DCLE, FEXE, FSEE, CDE, Evento de Invalidación Electrónico, Evento de Contingencia Electrónico',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'campo' => 'CAT-002',
                'catalogo' => 'Tipo de Documento',
                'descripcion' => 'Contiene los códigos asignados por la Administración Tributaria el cual hace referencia al Tipo de DTE, que se está transmitiendo.',
                'tipo' => 'FE, CCFE, NRE, NCE, NDE, CRE, CLE, DCLE, FEXE, CDE, FSEE, Evento de Invalidación Electrónico, Evento de Contingencia Electrónico',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'campo' => 'CAT-003',
                'catalogo' => 'Modelo de Facturación',
                'descripcion' => 'Contiene los códigos asignados por la Administración Tributaria.',
                'tipo' => 'FE, CCFE, NRE, NCE, NDE, CRE, CLE, DCLE, FEXE, FSEE, CDE',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'campo' => 'CAT-004',
                'catalogo' => 'Tipo de Transmisión',
                'descripcion' => 'Contiene los códigos que indican el modo en que se realiza la transmisión del documento (normal o Contingencia).',
                'tipo' => 'FE, CCFE, NRE, NCE, NDE, CRE, CLE, DCLE, FEXE, FSEE, CDE',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'campo' => 'CAT-005',
                'catalogo' => 'Tipo de Contingencia',
                'descripcion' => 'Contiene los códigos asignados por la Administración Tributaria para clasificar el tipo de causa de fuerza mayor que dificulta la transmisión y recepción de un DTE a la Administración Tributaria.',
                'tipo' => 'FE, CCFE, NRE, NCE, NDE, FEXE, FSEE, Evento de Contingencia Electrónico',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'campo' => 'CAT-006',
                'catalogo' => 'Retención IVA MH',
                'descripcion' => 'Contiene los códigos asignados por la Administración Tributaria para el tipo de retención que se aplica en el DTE.',
                'tipo' => 'CRE, FSEE',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'campo' => 'CAT-007',
                'catalogo' => 'Tipo de Generación del Documento',
                'descripcion' => 'Contiene los códigos asignados por la Administración Tributaria para indicar la forma en que fue generado el documento que se relaciona, ya sea de manera física o electrónica.',
                'tipo' => 'FE, CCFE, NRE, NCE, NDE, CRE, CLE',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'campo' => 'CAT-009',
                'catalogo' => 'Tipo de establecimiento',
                'descripcion' => 'Contiene los códigos asignados por la Administración Tributaria para el tipo de establecimiento donde es generado el DTE.',
                'tipo' => 'FE, CCFE, NRE, NCE, NDE, CRE, CLE, DCLE, FEXE, Evento de Invalidación Electrónico, Evento de Contingencia Electrónico',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'campo' => 'CAT-010',
                'catalogo' => 'Código tipo de Servicio (Médico)',
                'descripcion' => 'Contiene los códigos asignados por la Administración Tributaria para el tipo de Servicio médico que se utiliza cuando el modelo de negocio lo requiere.',
                'tipo' => 'FE, CCFE',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'campo' => 'CAT-011',
                'catalogo' => 'Tipo de ítem',
                'descripcion' => 'Contiene los códigos asignados por la Administración Tributaria para Indicar si la operación realizada corresponde.',
                'tipo' => 'FE, CCFE, NRE, NCE, NDE, FEXE, FSEE',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'campo' => 'CAT-012',
                'catalogo' => 'Departamento',
                'descripcion' => 'Contiene los códigos asignados por la Administración Tributaria para indicar el Departamento donde se encuentra ubicado el establecimiento del emisor del DTE.',
                'tipo' => 'FE, CCFE, NRE, NCE, NDE, CRE, CLE, DCLE, FEXE, CDE',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'campo' => 'CAT-013',
                'catalogo' => 'Municipio',
                'descripcion' => 'Contiene los códigos asignados por la Administración Tributaria para indicar el Municipio donde se encuentra ubicado el establecimiento donde se genera el DTE.',
                'tipo' => 'FE, CCFE, NRE, NCE, NDE, CRE, CLE, DCLE, FEXE, FSEE, CDE',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'campo' => 'CAT-014',
                'catalogo' => 'Unidad de Medida',
                'descripcion' => 'Contiene los códigos que identificarán la Unidad de Medida a utilizar de acuerdo al tipo de bien.',
                'tipo' => 'FE, CCFE, NRE, NCE, NDE, FEXE, FSEE, CDE',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'campo' => 'CAT-015',
                'catalogo' => 'Tributos',
                'descripcion' => 'Contiene los códigos asignados por la Administración Tributaria para los diferentes tributos requeridos de acuerdo al modelo de negocio.',
                'tipo' => 'FE, CCFE, NRE, NCE, NDE, CLE, FEXE',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'campo' => 'CAT-016',
                'catalogo' => 'Condición de la Operación',
                'descripcion' => 'Contiene los códigos que describen las Condiciones de la Operación pactadas que sea pactado entre el emisor y el receptor para el pago de sus operaciones, la cual puede ser contado, crédito u otros.',
                'tipo' => 'FE, CCFE, NCE, NDE, CLE, FEXE, FSEE',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'campo' => 'CAT-017',
                'catalogo' => 'Forma de Pago',
                'descripcion' => 'Contiene los códigos que describen las diferentes formas de pago sean estas: Efectivo, tarjeta de Débito, Tarjeta de Crédito entre otros, que el contribuyente acepte por el pago de sus operaciones.',
                'tipo' => 'FE, CCFE, FEXE, FSEE, CDE',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'campo' => 'CAT-018',
                'catalogo' => 'Plazo',
                'descripcion' => 'Contiene los códigos que describen los plazos pactados para las operaciones al crédito sean estos: días, meses o año, siempre y cuando su operación haya sido total o parcialmente al crédito.',
                'tipo' => 'FE, CCFE, FEXE, FSEE',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'campo' => 'CAT-019',
                'catalogo' => 'Código de Actividad Económica',
                'descripcion' => 'Contiene los códigos asignados por la Administración Tributaria para clasificar las diferentes Actividades Económicas. Dichos Códigos se encuentran publicados en la página WEB del Ministerio de Hacienda a través del link https://www.mh.gob.sv/documentos-y-publicaciones-varias/',
                'tipo' => 'FE, CCFE, NRE, NCE, NDE, CRE, CLE, DCLE, FEXE, FSEE, CDE',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'campo' => 'CAT-024',
                'catalogo' => 'Tipo de Invalidación',
                'descripcion' => 'Contiene los códigos que clasifican los diferentes motivos válidos por los cuales el emisor realizara el evento de invalidación.',
                'tipo' => 'Evento de Invalidación Electrónico',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'campo' => 'CAT-025',
                'catalogo' => 'Título a que se remiten los bienes',
                'descripcion' => 'Contiene los códigos que clasifican la condición para el traslado de los bienes por medio de una nota de remisión.',
                'tipo' => 'NRE',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'campo' => 'CAT-026',
                'catalogo' => 'Tipo de Donación',
                'descripcion' => 'Contiene los códigos que clasifican el tipo de donación de los bienes o servicios por medio de un comprobante de donación.',
                'tipo' => 'CDE',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'campo' => 'CAT-027',
                'catalogo' => 'Recinto fiscal',
                'descripcion' => 'Describe el Código de Recinto Fiscal, hace referencia al punto de aduana donde será el despacho de la mercancía a exportar.',
                'tipo' => 'FEXE',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'campo' => 'CAT-028',
                'catalogo' => 'Régimen',
                'descripcion' => 'Contiene los códigos que describen la condición bajo la cual se exporta la mercancía.',
                'tipo' => 'FEXE',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'campo' => 'CAT-029',
                'catalogo' => 'Tipo de persona',
                'descripcion' => 'Contiene los códigos que describen el Tipo de Persona sean estas Naturales o Jurídicas, a la que se le va a realizar la exportación.',
                'tipo' => 'FEXE',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'campo' => 'CAT-030',
                'catalogo' => 'Transporte',
                'descripcion' => 'Contiene los códigos que identifican el tipo de transporte utilizado para trasladar las mercancías.',
                'tipo' => 'FEXE',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'campo' => 'CAT-031',
                'catalogo' => 'INCOTERMS',
                'descripcion' => 'Contiene los códigos asignados por la Administración Tributaria que describen los términos y condiciones pactadas sobre las responsabilidades asumidas por cada una de las partes en la entrega de las mercancías.',
                'tipo' => 'FEXE',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'campo' => 'CAT-032',
                'catalogo' => 'Domicilio Fiscal',
                'descripcion' => 'Contiene los códigos que identifican el territorio o lugar de residencia del donante.',
                'tipo' => 'CDE',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('mh_catalogo_general')->insert($values);
    }
}
