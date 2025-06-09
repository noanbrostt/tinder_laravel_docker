<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use App\Models\User;


class InteracoesController extends Controller
{



    public function index(){ // Traz a lista de usuarios aprovados

          $usuarios = $this->listarInteracoes();
      
          return view('tinder', compact('usuarios'));
    }

    public function store(Request $request){ //Salva a interacao

        $request->validate([
            'matricula_destino' => 'required|integer',
            'id_tipo_interacao' => 'required|integer|in:1,2', // Like, Deslike
        ]);

        $dados = session('dados');

        if (!$dados || !isset($dados->matricula)) {
            return response()->json(['error' => 'Usuário não autenticado.'], 401);
        }

        $matriculaOrigem = $dados->matricula;
        $matriculaDestino = $request->input('matricula_destino');
        $tipoInteracao = $request->input('id_tipo_interacao');

        DB::connection('tinder2')->table('public.interacao')->insert([
            'matricula_origem' => $matriculaOrigem,
            'matricula_destino' => $matriculaDestino,
            'id_tipo_interacao' => $tipoInteracao,
            'dh_criacao' => Carbon::now()
        ]);

        $tipos = [
            1 => 'Like',
            2 => 'Deslike'
        ];

        return response()->json([
            'success' => true,
            'message' => "Interação '{$tipos[$tipoInteracao]}' registrada com sucesso.",
        ]);
    }


    public function listarMatches(){ // Lista os Matches do Usr logado

        $dados = session('dados');

        if (!$dados || !isset($dados->matricula)) {
            return response()->json(['error' => 'Usuário não autenticado.'], 401);
        }

        $matriculaMinha = $dados->matricula;

        $interacoesFeitas = DB::connection('tinder2')  // quem  curti com Like ou SuperLike
            ->table('public.interacao')
            ->select('matricula_destino')
            ->where('matricula_origem', $matriculaMinha)
            ->whereIn('id_tipo_interacao', [1]);
    

        $matches = DB::connection('tinder2') // Matches: pessoas também curtiram de volta
            ->table('public.interacao as i')
            ->join('public.usuario as u', 'i.matricula_origem', '=', 'u.matricula')
            ->whereIn('i.matricula_origem', $interacoesFeitas)
            ->where('i.matricula_destino', $matriculaMinha)
            ->whereIn('i.id_tipo_interacao', [1])
            ->select('u.nome', 'u.idade', 'u.de_sobre', 'u.matricula')
            ->distinct()
            ->get();
    
        return response()->json($matches); // ou view() se quiser renderizar na tela
    }

    public function verificarSeTemMatch(){ // Traz o total de Matchs ou null caso não tenha

        $dados = session('dados');

        $matriculaMinha = $dados->matricula;
    
        $interacoesFeitas = DB::connection('tinder2') // Subquery: pessoas que o usuário curtiu
            ->table('public.interacao')
            ->select('matricula_destino')
            ->where('matricula_origem', $matriculaMinha)
            ->whereIn('id_tipo_interacao', [1]);
    
        $quantidadeMatches = DB::connection('tinder2') // Conta os matches
            ->table('public.interacao as i')
            ->whereIn('i.matricula_origem', $interacoesFeitas)
            ->where('i.matricula_destino', $matriculaMinha)
            ->whereIn('i.id_tipo_interacao', [1])
            ->distinct()
            ->count('i.matricula_origem');
    
        return response()->json([
            'tem_match' => $quantidadeMatches > 0 ? $quantidadeMatches : null
        ]);
    }

    public function listarInteracoes(){

        $dados = session('dados');
    
        if (!$dados || !isset($dados->matricula)) {
            return response()->json(['error' => 'Usuário não autenticado.'], 401);
        }
    
        $matriculaMinha = $dados->matricula;
    
        // Pega todos os IDs que o usuário já interagiu
        $idsInteragidos = DB::connection('tinder2')
            ->table('public.interacao')
            ->where('matricula_origem', $matriculaMinha)
            ->pluck('matricula_destino');
    
        // 🔍 1. Usuários ativos que ainda não receberam interação
        $semInteracoes = DB::connection('tinder2')
            ->table('public.usuario as u')
            ->where('u.id_status_usuario', 2)
            ->where('u.matricula', '!=', $matriculaMinha)
            ->whereNotIn('u.matricula', $idsInteragidos)
            ->select('matricula', 'nome', 'idade', 'ti.no_tipo_intencao AS intencao','de_sobre')
            ->join('public.tipo_intencao as ti', 'u.id_tipo_intencao', '=', 'ti.id_tipo_intencao')
            ->get()
            ->map(function ($user) {
                $user->tipo = 'sem_interacao';
                return $user;
            });
    
        $interacoesDeslike = collect(); // coleção vazia por padrão
    
        // 🔍 2. Executa apenas se a primeira lista estiver vazia
        if ($semInteracoes->isEmpty()) {
            $interacoesDeslike = DB::connection('tinder2')
                ->table('public.interacao as i')
                ->join('public.usuario as u', 'i.matricula_destino', '=', 'u.matricula')
                ->join('public.tipo_intencao as ti', 'u.id_tipo_intencao', '=', 'ti.id_tipo_intencao')
                ->where('i.matricula_origem', $matriculaMinha)
                ->where('i.id_tipo_interacao', 2)
                ->select('u.matricula', 'u.nome', 'u.idade', 'ti.no_tipo_intencao AS intencao', 'u.de_sobre')
                ->get()
                ->map(function ($user) {
                    $user->tipo = 'dislike';
                    return $user;
                });
        }
    
        // 🔗 Junta as listas
        $resultado = $semInteracoes->merge($interacoesDeslike);
    
        return response()->json($resultado);
    }





    
}
