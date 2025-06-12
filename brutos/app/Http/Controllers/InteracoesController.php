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

    protected $adm = [677, 1097, 1110, 15, 255, 572, 574, 676, 15264]; // perfis com permissões (devs,coordenadores,gerentes)


    public function index() {
        // Traz a lista de usuarios aprovados
        $usr = session('dados'); // pega as infos do user logado
    
        if (!$usr) { // se não estiver logado 
            return response()->json([
                'status' => 'erro',
                'mensagem' => 'Sessão expirada. Por favor, faça login novamente.'
            ], 401);
        }


        $cadastro = DB::connection('tinder2')
            ->table('public.usuario')
            ->where('public.usuario.matricula', session('matricula'))
            ->where('id_status_usuario', '2')
            ->first();

        $possuiCadastro = (bool) $cadastro;

        // Para acessar o Tinder precisa ter cadastro ou ser coordenador
        if (!$possuiCadastro && !in_array($usr->co_funcao, $this->adm)) {
            return response()->json([
                'status' => 'erro',
                'mensagem' => 'Se quiser brincar é só fazer seu cadastro.'
            ], 401);
        }
    
        // // Verifica se a data e hora atual é superior 
        // $dataLimite = \Carbon\Carbon::createFromFormat('d/m/Y H:i', '12/06/2025 07:40');
        // $agora = \Carbon\Carbon::now();
    
        // if ($agora->lessThan($dataLimite)) {
        //     // Se ainda não passou da data/hora limite, valida a função
        //     $funcoesPermitidas = $this->adm;
    
        //     if (!in_array($usr->co_funcao, $funcoesPermitidas)) {
        //          return redirect()->route('login');
        //     }
        // }
    
        $usuarios = $this->listarInteracoes()->getData(true);
        $usuarios = $this->embaralharComPrioridade($usuarios);
    
        return view('tinder', compact('usuarios'));
    }


    public function store(Request $request){ // Salva ou atualiza a interação
    
        $request->validate([
            'matricula_destino' => 'required|integer',
            'id_tipo_interacao' => 'required|integer|in:1,2', // 1: Like, 2: Dislike
        ]);
    
        $dados = session('dados');
    
        if (!$dados || !isset($dados->matricula)) {
            return response()->json(['error' => 'Usuário não autenticado.'], 401);
        }
    
        $matriculaOrigem = $dados->matricula;
        $matriculaDestino = $request->input('matricula_destino');
        $tipoInteracao = $request->input('id_tipo_interacao');
    
        // ⚙️ updateOrInsert: se existir, atualiza; senão, insere
        $foiInserido = DB::connection('tinder2')
            ->table('public.interacao')
            ->updateOrInsert(
                [
                    'matricula_origem' => $matriculaOrigem,
                    'matricula_destino' => $matriculaDestino
                ],
                [
                    'id_tipo_interacao' => $tipoInteracao,
                    'dh_criacao' => now()
                ]
            );
    
        $tipos = [
            1 => 'Like',
            2 => 'Deslike'
        ];
    
        return response()->json([
            'success' => true,
            'message' => "Interação '{$tipos[$tipoInteracao]}' salva com sucesso.",
            'foi_inserido' => $foiInserido
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
            ->join('public.tipo_intencao as ti', 'u.id_tipo_intencao', '=', 'ti.id_tipo_intencao')
            ->whereIn('i.matricula_origem', $interacoesFeitas)
            ->where('i.matricula_destino', $matriculaMinha)
            ->whereIn('i.id_tipo_interacao', [1])
            ->select('u.nome', 'u.idade','u.login', 'u.de_sobre', 'u.matricula', 'ti.no_tipo_intencao AS intencao')
            ->distinct()
            ->get();
    
        return $matches;
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
            ->distinct()
            ->get()
            ->map(function ($user) {
                $user->tipo = 'sem_interacao';
                return $user;
            });
    
        $interacoesDeslike = collect(); // coleção vazia por padrão
    
        // 🔍 2. Executa apenas se a primeira lista estiver vazia

            $interacoesDeslike = DB::connection('tinder2')
                ->table('public.interacao as i')
                ->join('public.usuario as u', 'i.matricula_destino', '=', 'u.matricula')
                ->join('public.tipo_intencao as ti', 'u.id_tipo_intencao', '=', 'ti.id_tipo_intencao')
                ->where('i.matricula_origem', $matriculaMinha)
                ->where('i.id_tipo_interacao', 2)
                ->select('u.matricula', 'u.nome', 'u.idade', 'ti.no_tipo_intencao AS intencao', 'u.de_sobre')
                ->distinct()
                ->get()
                ->map(function ($user) {
                    $user->tipo = 'dislike';
                    return $user;
                });

    
        // 🔗 Junta as listas
        $resultado = $semInteracoes->merge($interacoesDeslike);
    
        return response()->json($resultado);
    }


    public function listarLikes(){

        $dados = session('dados');
    
        if (!$dados || !isset($dados->matricula)) {
            return response()->json(['error' => 'Usuário não autenticado.'], 401);
        }
    
        $matriculaMinha = $dados->matricula;
    
        // Carrega os matches diretamente como coleção
        $listarMatches = $this->listarMatches();
    
        $likesFeitos = DB::connection('tinder2')
            ->table('public.interacao as i')
            ->join('public.usuario as u', 'i.matricula_destino', '=', 'u.matricula')
            ->join('public.tipo_intencao as ti', 'u.id_tipo_intencao', '=', 'ti.id_tipo_intencao')
            ->where('i.matricula_origem', $matriculaMinha)
            ->where('i.id_tipo_interacao', 1)
            ->select('u.matricula', 'u.login','u.nome', 'u.idade', 'ti.no_tipo_intencao AS intencao', 'u.de_sobre')
            ->get();
    
        $likesRecebidos = DB::connection('tinder2')
            ->table('public.interacao as i')
            ->join('public.usuario as u', 'i.matricula_origem', '=', 'u.matricula')
            ->join('public.tipo_intencao as ti', 'u.id_tipo_intencao', '=', 'ti.id_tipo_intencao')
            ->where('i.matricula_destino', $matriculaMinha)
            ->where('i.id_tipo_interacao', 1)
            ->select('u.matricula', 'u.login','u.nome', 'u.idade', 'ti.no_tipo_intencao AS intencao', 'u.de_sobre')
            ->get();


        // Extrai as matrículas dos matches (como uma Collection de IDs)
        $matriculasMatches = collect($listarMatches)->pluck('matricula');

        // Remove os usuários que já são matches
        $likesFeitos = $likesFeitos->reject(function ($like) use ($matriculasMatches) {
            return $matriculasMatches->contains($like->matricula);
        });

        $likesRecebidos = $likesRecebidos->reject(function ($like) use ($matriculasMatches) {
            return $matriculasMatches->contains($like->matricula);
        });

    
        return view('matchs', compact('likesFeitos', 'likesRecebidos', 'listarMatches'));
    }

    function embaralharComPrioridade(array $usuarios): array
    {
        // Separa os perfis por tipo
        $semInteracao = array_filter($usuarios, fn($p) => $p['tipo'] === 'sem_interacao');
        $outros = array_filter($usuarios, fn($p) => $p['tipo'] !== 'sem_interacao');

        // Embaralha os dois grupos
        shuffle($semInteracao);
        shuffle($outros);

        // Junta os 'sem_interacao' primeiro
        return array_merge($semInteracao, $outros);
    }


}
