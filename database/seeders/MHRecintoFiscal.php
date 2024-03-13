<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MHRecintoFiscal extends Seeder
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
                'valor' => 'Terrestre San Bartolo',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '02',
                'valor' => 'Marítima de Acajutla',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '03',
                'valor' => 'Aérea Monseñor Óscar Arnulfo Romero',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '04',
                'valor' => 'Terrestre Las Chinamas',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '05',
                'valor' => 'Terrestre La Hachadura',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '06',
                'valor' => 'Terrestre Santa Ana',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '07',
                'valor' => 'Terrestre San Cristóbal',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '08',
                'valor' => 'Terrestre Anguiatú',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '09',
                'valor' => 'Terrestre El Amatillo',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '10',
                'valor' => 'Marítima La Unión (Puerto Cutuco)',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '11',
                'valor' => 'Terrestre El Poy',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '12',
                'valor' => 'Aduana Terrestre Metalío',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '15',
                'valor' => 'Fardos Postales',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '16',
                'valor' => 'Z.F. San Marcos',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '17',
                'valor' => 'Z.F. El Pedregal',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '18',
                'valor' => 'Z.F. San Bartolo',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '20',
                'valor' => 'Z.F. Exportsalva',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '21',
                'valor' => 'Z.F. American Park',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '23',
                'valor' => 'Z.F. Internacional',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '24',
                'valor' => 'Z.F. Diez',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '26',
                'valor' => 'Z.F. Miramar',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '27',
                'valor' => 'Z.F. Santo Tomas',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '28',
                'valor' => 'Z.F. Santa Tecla',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '29',
                'valor' => 'Z.F. Santa Ana',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '30',
                'valor' => 'Z.F. La Concordia',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '31',
                'valor' => 'Aérea Ilopango',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '32',
                'valor' => 'Z.F. Pipil',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '33',
                'valor' => 'Puerto Barillas',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '34',
                'valor' => 'Z.F. Calvo Conservas',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '35',
                'valor' => 'Feria Internacional',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '36',
                'valor' => 'Delg. Aduana El Papalón',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '37',
                'valor' => 'Z.F. Parque Industrial Sam-Li',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '38',
                'valor' => 'Z.F. San José',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '39',
                'valor' => 'Z.F. Las Mercedes',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '71',
                'valor' => 'Almacenes De Desarrollo (Aldesa)',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '72',
                'valor' => 'Almac. Gral. Dep. Occidente (Agdosa)',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '73',
                'valor' => 'Bodega General De Depósito (Bodesa)',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '76',
                'valor' => 'DHL',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '77',
                'valor' => 'Transauto (Santa Elena)',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '80',
                'valor' => 'Almacenadora Nejapa, S.a. de C.V.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '81',
                'valor' => 'Almacenadora Almaconsa S.A. De C.V.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '83',
                'valor' => 'Alm.Gral. Depósito Occidente (Apopa)',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '99',
                'valor' => 'San Bartolo Envío Hn/Gt',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('mh_recinto_fiscal')->insert($values);
    }
}
