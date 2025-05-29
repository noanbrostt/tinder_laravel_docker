<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inscricao;
use Illuminate\Support\Facades\Storage;

class InscricaoController extends Controller{

    public function store(Request $request){

    $dados = session('dados');
    
    if (!$dados) {
        return response()->json([
            'error' => 'Dados do usuário não encontrados na sessão.'
        ], 400);
    }
    
    $matricula = $dados->matricula ?? null;
    $nome = $dados->nome ?? null;
    $dtnascimento = $dados->dtnascimento ?? null;
    
    if (!$matricula || !$nome || !$dtnascimento) {
        return response()->json([
            'error' => 'Dados obrigatórios estão incompletos.'
        ], 400);
    }
    
    $idade = \Carbon\Carbon::parse($dtnascimento)->age;
  
      // 📌 Validar dados do request
      $request->validate([
          'foto' => 'required|image|mimes:jpg,jpeg,png|max:2048',
          'intencao' => 'required|integer|exists:tipo_intencao,id_tipo_intencao',
          'sobre' => 'required|string|max:240',
      ]);
  
      // 📷 Salvar a imagem no disco
      $fotoPath = $request->file('foto')->store('public/fotos');
  
      // 🗂 Inserir dados na tabela usuario
      DB::table('usuario')->insert([
          'matricula' => $matricula,
          'nome' => $nome,
          'idade' => $idade,
          'de_sobre' => $request->input('sobre'),
          'id_tipo_intencao' => $request->input('intencao'),
          'id_status_usuario' => 1, // Pendente
          'dh_criacao' => now(),
          'dh_alteracao' => now(),
      ]);
  
      return response()->json([
          'success' => true,
          'message' => 'Inscrição salva com sucesso!'
      ]);
    }

}

?>