<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TipoInteracao;

class TipoInteracaoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TipoInteracao::upsert(
            [
                ['id_tipo_interacao' => 1, 'no_tipo_interacao' => 'Like'],
                ['id_tipo_interacao' => 2, 'no_tipo_interacao' => 'Deslike'],
                ['id_tipo_interacao' => 3, 'no_tipo_interacao' => 'SuperLike'],
            ],
            ['id_tipo_interacao'], // Chave única
            ['no_tipo_interacao']  // Coluna para atualizar
        );
    }
}