<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TipoIntencao;

class TipoIntencaoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TipoIntencao::upsert(
            [
                ['id_tipo_intencao' => 1, 'no_tipo_intencao' => 'Amizade'],
                ['id_tipo_intencao' => 2, 'no_tipo_intencao' => 'Namoro'],
                ['id_tipo_intencao' => 3, 'no_tipo_intencao' => 'Outros'],
            ],
            ['id_tipo_intencao'], // Chave única
            ['no_tipo_intencao']  // Coluna para atualizar
        );
    }
}