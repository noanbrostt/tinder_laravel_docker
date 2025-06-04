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

class ValidarInscricao extends Controller{


    protected $adm = [677, 1097, 1110, 15, 255, 572, 574, 676, 15264]; // perfis com permissões (devs,coordenadores,gerentes)


    public function home(){
        $matricula = session('matricula');

        return view('validar', compact('matricula'));
    }


    public function listarInscricoes(){
        $usuario = session('dados'); // pega as infos do user logado
    
        if (!$usuario) { // se não estiver logado 
            return response()->json([
                'status' => 'erro',
                'mensagem' => 'Sessão expirada. Por favor, faça login novamente.'
            ], 401);
        }
    
        $funcoesPermitidas = $this->adm;
    
        if (!in_array($usuario->co_funcao, $funcoesPermitidas)) {
            return response()->json([
                'status' => 'erro',
                'mensagem' => 'Acesso negado. Sua função não permite acessar esta área.'
            ], 403);
        }
    
        $inscricoes = DB::connection('tinder2')
            ->table('public.usuario as u')
            ->join('public.tipo_intencao as ti', 'u.id_tipo_intencao', '=', 'ti.id_tipo_intencao')
            ->join('public.status_usuario as st', 'st.id_status_usuario', '=', 'u.id_status_usuario')
            ->select(
                'u.id_usuario',
                'u.matricula',
                'u.nome',
                'ti.no_tipo_intencao as intencao',
                'st.no_status_usuario as status_usr',
                'u.de_sobre as sobre' )
            ->get();

    
        return response()->json($inscricoes);
    }

    public function atualizarInscricao(Request $request){

        $request->validate([
            'matricula' => 'required|integer',
            'classificacao' => 'required|string',
            'matricula_recusa' => 'required|string',
        ]);
    
        $status = $request->classificacao === 'aprovado' ? 2 : 3;
    
        // Define observação de recusa: usa explicação se enviada, senão null
        $observacao = $request->filled('explicacao') ? $request->explicacao : null;
    
        // Define id_motivo_recusa: apenas se for recusado
        $idMotivoRecusa = $status === 3 ? $request->classificacao : null;
    
        // Realiza o update
        $update = DB::connection('tinder2')
            ->table('public.usuario')
            ->where('matricula', $request->matricula)
            ->update([
                'id_status_usuario'   => $status,
                'id_motivo_recusa'    => $idMotivoRecusa,
                'de_observacao_recusa'=> $observacao,
                'matricula_recusa'    => $request->matricula_recusa,
                'dh_alteracao'        => now(),
            ]);
    
        return response()->json([
            'status'   => $update ? 'success' : 'erro',
            'mensagem' => $update ? 'Inscrição atualizada com sucesso.' : 'Nenhuma alteração realizada.',
        ]);
    }

    
}
