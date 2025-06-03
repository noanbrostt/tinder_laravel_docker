<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\StatusUsuario;

class StatusUsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        StatusUsuario::upsert(
            [
                ['id_status_usuario' => 1, 'no_status_usuario' => 'Em revisao'],
                ['id_status_usuario' => 2, 'no_status_usuario' => 'Ativo'],
                ['id_status_usuario' => 3, 'no_status_usuario' => 'Recusado'],
                ['id_status_usuario' => 4, 'no_status_usuario' => 'Desativado'],
            ],
            ['id_status_usuario'], // Chave única
            ['no_status_usuario']  // Coluna para atualizar
        );
    }
}