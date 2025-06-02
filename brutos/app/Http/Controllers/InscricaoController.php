<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inscricao;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

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
           'intencao' => 'required|integer|in:1,2,3', // aceita somente os valores dessa lista
           'sobre' => 'required|string|max:240',
       ]);

  
         // 📷 Salvar a imagem com o nome da matrícula
       $nomeArquivo = $matricula . '.jpg'; // ou .png dependendo do tipo
       $caminho = 'public/fotos/' . $nomeArquivo;
       
       $request->file('foto')->storeAs('fotos', $nomeArquivo, 'public');
       $fotoUrl = 'storage/fotos/' . $nomeArquivo; // Gerar o caminho acessível publicamente
       



      // 🗂 Inserir dados na tabela usuario
      DB::connection('tinder2')->table('public.usuario')->insert([
          'matricula' => $matricula,
          'nome' => $nome,
          'idade' => $idade,
          'de_sobre' => $request->input('sobre'),
          'id_tipo_intencao' => $request->input('intencao'),
          'id_status_usuario' => 1,
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