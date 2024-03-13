<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MHPais extends Seeder
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
                'codigo' => '9320',
                'valor' => 'ANGUILA',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9539',
                'valor' => 'ISLAS TURCAS Y CAICOS',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9565',
                'valor' => 'LITUANIA',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9905',
                'valor' => 'DAKOTA DEL SUR (USA)',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9999',
                'valor' => 'No definido en migración',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9303',
                'valor' => 'AFGANISTÁN',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9306',
                'valor' => 'ALBANIA',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9309',
                'valor' => 'ALEMANIA OCCIDENTAL',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9310',
                'valor' => 'ALEMANIA ORIENTAL',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9315',
                'valor' => 'ALTO VOLTA',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9317',
                'valor' => 'ANDORRA',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9318',
                'valor' => 'ANGOLA',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9319',
                'valor' => 'ANTIGUA Y BARBUDA',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9324',
                'valor' => 'ARABIA SAUDITA',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9327',
                'valor' => 'ARGELIA',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9330',
                'valor' => 'ARGENTINA',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9333',
                'valor' => 'AUSTRALIA',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9336',
                'valor' => 'AUSTRIA',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9339',
                'valor' => 'BANGLADESH',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9342',
                'valor' => 'BAHRÉIN',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9345',
                'valor' => 'BARBADOS',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9348',
                'valor' => 'BÉLGICA',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9349',
                'valor' => 'BELICE',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9350',
                'valor' => 'BENÍN',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9354',
                'valor' => 'BIRMANIA',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9357',
                'valor' => 'BOLIVIA',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9360',
                'valor' => 'BOTSWANA',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9363',
                'valor' => 'BRASIL',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9366',
                'valor' => 'BRUNÉI',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9372',
                'valor' => 'BURUNDI',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9374',
                'valor' => 'BOPHUTHATSWANA',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9375',
                'valor' => 'BUTÁN',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9377',
                'valor' => 'CABO VERDE',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9378',
                'valor' => 'CAMBOYA',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9381',
                'valor' => 'CAMERÚN',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9384',
                'valor' => 'CANADÁ',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9387',
                'valor' => 'CEILÁN',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9390',
                'valor' => 'CTRO AFRIC REP',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9393',
                'valor' => 'COLOMBIA',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9394',
                'valor' => 'COMORAS-ISLAS',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9396',
                'valor' => 'CONGO REP DEL',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9399',
                'valor' => 'CONGO REP DEMOC',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9402',
                'valor' => 'COREA NORTE',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9405',
                'valor' => 'COREA SUR',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9408',
                'valor' => 'COSTA DE MARFIL',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9411',
                'valor' => 'COSTA RICA',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9414',
                'valor' => 'CUBA',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9417',
                'valor' => 'CHAD',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9420',
                'valor' => 'CHECOSLOVAQUIA',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9423',
                'valor' => 'CHILE',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9426',
                'valor' => 'CHINA REP POPUL',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9432',
                'valor' => 'CHIPRE',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9435',
                'valor' => 'DAHOMEY',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9438',
                'valor' => 'DINAMARCA',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9440',
                'valor' => 'DOMINICA',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9441',
                'valor' => 'DOMINICANA REP',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'codigo' => '9444',
                'valor' => 'ECUADOR',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'codigo' => '9446',
                'valor' => 'EMIRAT ARAB UNI',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'codigo' => '9447',
                'valor' => 'ESPAÑA',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'codigo' => '9450',
                'valor' => 'EE UU',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'codigo' => '9453',
                'valor' => 'ETIOPIA',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'codigo' => '9456',
                'valor' => 'FIJI-ISLAS',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'codigo' => '9459',
                'valor' => 'FILIPINAS',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'codigo' => '9462',
                'valor' => 'FINLANDIA',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'codigo' => '9465',
                'valor' => 'FRANCIA',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'codigo' => '9468',
                'valor' => 'GABÓN',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'codigo' => '9471',
                'valor' => 'GAMBIA',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9474',
                'valor' => 'GHANA',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'codigo' => '9477',
                'valor' => 'GIBRALTAR',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'codigo' => '9480',
                'valor' => 'GRECIA',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'codigo' => '9481',
                'valor' => 'GRENADA',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'codigo' => '9483',
                'valor' => 'GUATEMALA',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'codigo' => '9486',
                'valor' => 'GUINEA',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'codigo' => '9487',
                'valor' => 'GUYANA',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'codigo' => '9495',
                'valor' => 'HAITÍ',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'codigo' => '9498',
                'valor' => 'HOLANDA',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'codigo' => '9501',
                'valor' => 'HONDURAS',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'codigo' => '9504',
                'valor' => 'HONG KONG',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'codigo' => '9507',
                'valor' => 'HUNGRÍA',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9513',
                'valor' => 'INDONESIA',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'codigo' => '9516',
                'valor' => 'IRAK',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'codigo' => '9519',
                'valor' => 'IRÁN',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'codigo' => '9522',
                'valor' => 'IRLANDA',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'codigo' => '9525',
                'valor' => 'ISLANDIA',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'codigo' => '9526',
                'valor' => 'ISLAS SALOMÓN',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'codigo' => '9528',
                'valor' => 'ISRAEL',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'codigo' => '9531',
                'valor' => 'ITALIA',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'codigo' => '9534',
                'valor' => 'JAMAICA',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'codigo' => '9537',
                'valor' => 'JAPÓN',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'codigo' => '9540',
                'valor' => 'JORDANIA',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'codigo' => '9543',
                'valor' => 'KENIA',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9544',
                'valor' => 'KIRIBATI',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'codigo' => '9546',
                'valor' => 'KUWAIT',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'codigo' => '9549',
                'valor' => 'LAOS',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'codigo' => '9552',
                'valor' => 'LESOTHO',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'codigo' => '9555',
                'valor' => 'LÍBANO',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'codigo' => '9558',
                'valor' => 'LIBERIA',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'codigo' => '9561',
                'valor' => 'LIBIA',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'codigo' => '9564',
                'valor' => 'LIECHTENSTEIN',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'codigo' => '9567',
                'valor' => 'LUXEMBURGO',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'codigo' => '9570',
                'valor' => 'MADAGASCAR',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'codigo' => '9573',
                'valor' => 'MALASIA',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'codigo' => '9576',
                'valor' => 'MALAWI',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9577',
                'valor' => 'MALDIVAS',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'codigo' => '9582',
                'valor' => 'MALTA',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'codigo' => '9585',
                'valor' => 'MARRUECOS',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'codigo' => '9591',
                'valor' => 'MASCATE Y OMÁN',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'codigo' => '9594',
                'valor' => 'MAURICIO',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'codigo' => '9597',
                'valor' => 'MAURITANIA',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'codigo' => '9600',
                'valor' => 'MÉXICO',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'codigo' => '9601',
                'valor' => 'MICRONESIA',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'codigo' => '9603',
                'valor' => 'MÓNACO',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'codigo' => '9606',
                'valor' => 'MONGOLIA',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'codigo' => '9609',
                'valor' => 'MOZAMBIQUE',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'codigo' => '9611',
                'valor' => 'NAURU',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9612',
                'valor' => 'NEPAL',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'codigo' => '9615',
                'valor' => 'NICARAGUA',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'codigo' => '9618',
                'valor' => 'NÍGER',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'codigo' => '9621',
                'valor' => 'NIGERIA',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'codigo' => '9624',
                'valor' => 'NORUEGA',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'codigo' => '9627',
                'valor' => 'NVA CALEDONIA',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'codigo' => '9633',
                'valor' => 'NVA ZELANDIA',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'codigo' => '9636',
                'valor' => 'NUEVAS HEBRIDAS',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'codigo' => '9638',
                'valor' => 'PAPUA NV GUINEA',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'codigo' => '9639',
                'valor' => 'PAKISTÁN',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'codigo' => '9642',
                'valor' => 'PANAMÁ',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'codigo' => '9645',
                'valor' => 'PARAGUAY',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9648',
                'valor' => 'PERÚ',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9651',
                'valor' => 'POLONIA',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9660',
                'valor' => 'QATAR EL',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9663',
                'valor' => 'REINO UNIDO',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9666',
                'valor' => 'EGIPTO',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9669',
                'valor' => 'RODESIA',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9672',
                'valor' => 'RUANDA',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9675',
                'valor' => 'RUMANIA',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9677',
                'valor' => 'SAN MARINO',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9678',
                'valor' => 'SAMOA OCCID',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9679',
                'valor' => 'SAINT KITTS AND NEVIS',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9680',
                'valor' => 'SANTA LUCIA',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9681',
                'valor' => 'SENEGAL',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9682',
                'valor' => 'SAOTOME Y PRINC',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9683',
                'valor' => 'SN VIC Y GRENAD',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9684',
                'valor' => 'SIERRA LEONA',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9687',
                'valor' => 'SINGAPUR',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9690',
                'valor' => 'SIRIA',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9691',
                'valor' => 'SEYCHELLES',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9693',
                'valor' => 'SOMALIA',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9696',
                'valor' => 'SUDÁFRICA REP',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9699',
                'valor' => 'SUDAN',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9702',
                'valor' => 'SUECIA',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9705',
                'valor' => 'SUIZA',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9706',
                'valor' => 'SURINAM',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9707',
                'valor' => 'SRI LANKA',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9708',
                'valor' => 'SUECILANDIA',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9714',
                'valor' => 'TANZANIA',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9717',
                'valor' => 'TOGO',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9720',
                'valor' => 'TRINIDAD TOBAGO',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9722',
                'valor' => 'TONGA',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9723',
                'valor' => 'TÚNEZ',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9725',
                'valor' => 'TRANSKEI',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9726',
                'valor' => 'TURQUÍA',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9727',
                'valor' => 'TUVALU',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9729',
                'valor' => 'UGANDA',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9732',
                'valor' => 'U R S S',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9735',
                'valor' => 'URUGUAY',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9738',
                'valor' => 'VATICANO',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9739',
                'valor' => 'VANUATU',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9740',
                'valor' => 'VENDA',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9741',
                'valor' => 'VENEZUELA',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9744',
                'valor' => 'VIETNAM NORTE',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9747',
                'valor' => 'VIETNAM SUR',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9750',
                'valor' => 'YEMEN SUR REP',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9756',
                'valor' => 'YUGOSLAVIA',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9758',
                'valor' => 'ZAIRE',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9759',
                'valor' => 'ZAMBIA',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9760',
                'valor' => 'ZIMBABWE',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9850',
                'valor' => 'PUERTO RICO',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9862',
                'valor' => 'BAHAMAS',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9863',
                'valor' => 'BERMUDAS',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9865',
                'valor' => 'MARTINICA',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9886',
                'valor' => 'NUEVA GUINEA',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9898',
                'valor' => 'ANT HOLANDESAS',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9899',
                'valor' => 'TAIWÁN',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9897',
                'valor' => 'ISLAS VÍRGENES BRITÁNICAS',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9887',
                'valor' => 'ISLAS GRAN CAIMÁN',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9571',
                'valor' => 'MACEDONIA',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9300',
                'valor' => 'EL SALVADOR',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9369',
                'valor' => 'BULGARIA',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9439',
                'valor' => 'DJIBOUTI',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9510',
                'valor' => 'INDIA',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9579',
                'valor' => 'MALI',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9654',
                'valor' => 'PORTUGAL',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9711',
                'valor' => 'TAILANDIA',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9736',
                'valor' => 'UCRANIA',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9737',
                'valor' => 'UZBEKISTÁN',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9640',
                'valor' => 'PALESTINA',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9641',
                'valor' => 'CROACIA',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9673',
                'valor' => 'REPUBLICA DE ARMENIA',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9472',
                'valor' => 'GEORGIA',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9311',
                'valor' => 'ALEMANIA',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9733',
                'valor' => 'RUSIA',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9541',
                'valor' => 'KASAKISTAN',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9746',
                'valor' => 'VIETNAM',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9551',
                'valor' => 'LETONIA',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9451',
                'valor' => 'ESLOVENIA',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9338',
                'valor' => 'AZERBAIYÁN',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9353',
                'valor' => 'BIELORRUSIA',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9482',
                'valor' => 'GROENLANDIA',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9494',
                'valor' => 'GUINEA-BISSAU',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9524',
                'valor' => 'ISLA DE COCOS',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9304',
                'valor' => 'ALAND',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9332',
                'valor' => 'ARUBA',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9454',
                'valor' => 'ERITREA',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9457',
                'valor' => 'ESTONIA',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9489',
                'valor' => 'GUADALUPE',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9491',
                'valor' => 'GUAYANA FRANCESA',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9492',
                'valor' => 'GUERNSEY',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9523',
                'valor' => 'ISLA DE NAVIDAD',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9530',
                'valor' => 'ISLAS AZORES',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9532',
                'valor' => 'ISLA QESHM',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9535',
                'valor' => 'ISLAS MARIANAS DEL NORTE',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9542',
                'valor' => 'ISLAS ULTRAMARINAS DE EE UU',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9547',
                'valor' => 'JERSEY',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9548',
                'valor' => 'KIRGUISTÁN',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9574',
                'valor' => 'MALI',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9598',
                'valor' => 'MAYOTTE',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9602',
                'valor' => 'MOLDAVIA',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9607',
                'valor' => 'MONTENEGRO',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9608',
                'valor' => 'MONSERRAT',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9623',
                'valor' => 'NORFOLK',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9652',
                'valor' => 'POLINESIA FRANCESA',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9692',
                'valor' => 'SVALBARD Y JAN MAYEN',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9709',
                'valor' => 'TAYIKISTÁN',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9712',
                'valor' => 'TERRITORIO BRITÁNICO DEL OCÉANO INDICO',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9716',
                'valor' => 'TIMOR ORIENTAL',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9718',
                'valor' => 'TOKELAU',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9719',
                'valor' => 'TURKMENISTÁN',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9751',
                'valor' => 'YIBUTI',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9452',
                'valor' => 'WALLIS Y FUTUNA',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9901',
                'valor' => 'NEVADA (USA)',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9902',
                'valor' => 'WYOMING (USA)',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9903',
                'valor' => "CAMPIONE D'ITALIA, ITALIA",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9664',
                'valor' => 'REPUBLICA CHECA',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9415',
                'valor' => 'CURAZAO',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9904',
                'valor' => 'FLORIDA (USA)',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9514',
                'valor' => 'INGLATERRA Y GALES',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9906',
                'valor' => 'TEXAS (USA)',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9359',
                'valor' => 'BOSNIA Y HERZEGOVINA',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9493',
                'valor' => 'GUINEA ECUATORIAL',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9521',
                'valor' => 'ISLA DE MAN',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9533',
                'valor' => 'ISLAS MALVINAS',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9538',
                'valor' => 'ISLAS PITCAIM',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9689',
                'valor' => 'SERBIA',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9713',
                'valor' => 'TERRITORIOS AUSTRALES FRANCESES',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9449',
                'valor' => 'ESLOVAQUIA',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9888',
                'valor' => 'SAN MAARTEN',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9490',
                'valor' => 'GUAM',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9527',
                'valor' => 'ISLAS COOK',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9529',
                'valor' => 'ISLAS FEROE',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9536',
                'valor' => 'ISLAS MARSHALL',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9545',
                'valor' => 'ISLAS VÍRGENES ESTADOUNIDENSES',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9568',
                'valor' => 'MACAO',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9610',
                'valor' => 'NAMIBIA',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9622',
                'valor' => 'NIUE',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9643',
                'valor' => 'PALAOS',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9667',
                'valor' => 'REUNIÓN',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9676',
                'valor' => 'SAHARA OCCIDENTAL',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9685',
                'valor' => 'SAMOA AMERICANA',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9686',
                'valor' => 'SAN PEDRO Y MIQUELÓN',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9688',
                'valor' => 'SANTA ELENA',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9715',
                'valor' => 'TERRITORIOS PALESTINOS',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9900',
                'valor' => 'DELAWARE (USA)',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9371',
                'valor' => 'BURKINA FASO',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9376',
                'valor' => 'CABINDA',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '9907',
                'valor' => 'WASHINGTON (USA)',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        DB::table('mh_pais')->insert($values);
    }
}
