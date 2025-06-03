<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class ValidarInscricao extends Controller
{
    public function listarInscricoes(){
        $usuario = session('dados'); // pega as infos do user logado
    
        if (!$usuario) { // se não estiver logado 
            return response()->json([
                'status' => 'erro',
                'mensagem' => 'Sessão expirada. Por favor, faça login novamente.'
            ], 401);
        }
    
        $funcoesPermitidas = [677,1097,1110,15,255,572,574,676,15264]; // perfis com permições (devs,coordenadores,gerentes)
    
        if (!in_array($usuario->co_funcao, $funcoesPermitidas)) {
            return response()->json([
                'status' => 'erro',
                'mensagem' => 'Acesso negado. Sua função não permite acessar esta área.'
            ], 403);
        }
    
        $inscricoes = DB::connection('tinder2')
            ->table('public.usuario as u')
            ->join('public.tipo_intencao as ti', 'u.id_tipo_intencao', '=', 'ti.id_tipo_intencao')
            ->select(
                'u.id_usuario',
                'u.matricula',
                'u.nome',
                'ti.no_tipo_intencao as intencao',
                'u.de_sobre as sobre'
            )
            ->get();
    
        return response()->json($inscricoes);
    }

}
