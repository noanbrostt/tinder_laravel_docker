<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ValidarInscricao extends Controller
{
    public function listarInscricoes()
    {
        $inscricoes = DB::connection('tinder2')
            ->table('public.usuario as u')
            ->join('public.tipo_intencao as ti', 'u.id_tipo_intencao', '=', 'ti.id_tipo_intencao')
            ->select(
                'u.matricula',
                'u.nome',
                'ti.no_tipo_intencao as intencao',
                'u.de_sobre as sobre'
            )
            ->get();

        return response()->json($inscricoes);
    }
}
