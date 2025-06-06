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




    public function index(){

          $usuarios = DB::connection('tinder2')
              ->table('public.usuario as u')
              ->select('u.matricula', 'u.nome', 'u.idade', 'u.de_sobre','u.id_tipo_intencao',
              'ti.no_tipo_intencao as intencao')
              ->join('public.tipo_intencao as ti', 'u.id_tipo_intencao', '=', 'ti.id_tipo_intencao')
              ->where('id_status_usuario', 2) // Somente usuários aprovados
              ->orderByDesc('dh_alteracao')
              ->get();
      
          return view('tinder', compact('usuarios'));
    }

    public function store(Request $request){

        $request->validate([
            'matricula_destino' => 'required|integer',
            'id_tipo_interacao' => 'required|integer|in:1,2,3', // Like, Deslike, SuperLike
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
            2 => 'Deslike',
            3 => 'SuperLike'
        ];

        return response()->json([
            'success' => true,
            'message' => "Interação '{$tipos[$tipoInteracao]}' registrada com sucesso.",
        ]);
    }


    public function listarMatches(){

        $dados = session('dados');

        if (!$dados || !isset($dados->matricula)) {
            return response()->json(['error' => 'Usuário não autenticado.'], 401);
        }
       

        $matriculaMinha = $dados->matricula;

        $interacoesFeitas = DB::connection('tinder2')  // quem  curti com Like ou SuperLike
            ->table('public.interacao')
            ->select('matricula_destino')
            ->where('matricula_origem', $matriculaMinha)
            ->whereIn('id_tipo_interacao', [1, 3]);
    

        $matches = DB::connection('tinder2') // Matches: pessoas também curtiram de volta
            ->table('public.interacao as i')
            ->join('public.usuario as u', 'i.matricula_origem', '=', 'u.matricula')
            ->whereIn('i.matricula_origem', $interacoesFeitas)
            ->where('i.matricula_destino', $matriculaMinha)
            ->whereIn('i.id_tipo_interacao', [1, 3])
            ->select('u.nome', 'u.idade', 'u.de_sobre', 'u.matricula')
            ->distinct()
            ->get();
    
        return response()->json($matches); // ou view() se quiser renderizar na tela
    }





    
}
