<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MotivoRecusa;

class MotivoRecusaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MotivoRecusa::upsert(
            [
                ['id_motivo_recusa' => 1, 'no_motivo_recusa' => 'Foto imprópria', 'legenda' => 'Foto não pode conter conteudo explicito.'],
                ['id_motivo_recusa' => 2, 'no_motivo_recusa' => 'Descrição imprópria', 'legenda' => 'Descrição não pode conter conteudo explicito.'],
                ['id_motivo_recusa' => 3, 'no_motivo_recusa' => 'Foto e texto impróprios', 'legenda' => 'Foto e/ou descrição não podem conter conteúdo explícito.'],
            ],
            ['id_motivo_recusa'], // Chave única para verificar a existência
            ['no_motivo_recusa', 'legenda'] // Colunas para atualizar caso já exista
        );
    }
}