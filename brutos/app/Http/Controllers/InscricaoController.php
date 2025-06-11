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

    public function home(){
        $matricula = session('matricula');
        $dados = session('dados');

        $cadastro = DB::connection('tinder2')
            ->table('public.usuario')
            ->leftJoin('public.motivo_recusa', 'public.usuario.id_motivo_recusa', '=', 'public.motivo_recusa.id_motivo_recusa')
            ->where('public.usuario.matricula', $matricula)
            ->select('public.usuario.*', 'public.motivo_recusa.no_motivo_recusa')
            ->first();

        $possuiCadastro = (bool) $cadastro;

        return view('inscricao', compact('cadastro', 'possuiCadastro', 'dados'));
    }

    public function store(Request $request){

        $dados = session('dados');
        
        if (!$dados) {
            return response()->json([
                'error' => 'Dados do usuário não encontrados na sessão.'
            ], 400);
        }
        
        $matricula = $dados->matricula ?? null;
        $login = $dados->login ?? null;
        $nome = $dados->nome ?? null;
        $dtnascimento = $dados->dtnascimento ?? null;
        
        if (!$matricula || !$nome || !$dtnascimento || !$login) {
            return response()->json([
                'error' => 'Dados obrigatórios estão incompletos.'
            ], 400);
        }
        
        $idade = \Carbon\Carbon::parse($dtnascimento)->age;


        $cadastro = DB::connection('tinder2')
        ->table('public.usuario')
        ->where('matricula', $matricula) 
        ->first(); 

        if($cadastro){
            return $this->atualizarCadastro($matricula, $request);
        }
    
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
            'login'=> $login,
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


    public function atualizarCadastro($matricula, Request $request){

    
        // 🧹 Apagar a foto antiga, se existir
        $nomeArquivo = $matricula . '.jpg'; // ou .png dependendo do seu padrão
        $caminho = 'public/fotos/' . $nomeArquivo;
    
        if (Storage::disk('public')->exists('fotos/' . $nomeArquivo)) {
            Storage::disk('public')->delete('fotos/' . $nomeArquivo);
        }
    
        // 📷 Salvar a nova imagem
        $request->file('foto')->storeAs('fotos', $nomeArquivo, 'public');
        $fotoUrl = 'storage/fotos/' . $nomeArquivo;
    
        // 🗂 Atualizar os dados no banco
        DB::connection('tinder2')->table('public.usuario')
            ->where('matricula', $matricula)
            ->update([
                'de_sobre' => $request->input('sobre'),
                'id_tipo_intencao' => $request->input('intencao'),
                'id_status_usuario' => 1, // reseta a permição e o resto para o padrão original
                'id_motivo_recusa' => null,
                'de_observacao_recusa'=> null,
                'matricula_recusa'=> null,
                'dh_alteracao' => now(),
            ]);
    
        return response()->json([
            'success' => true,
            'message' => 'Cadastro atualizado com sucesso!',
            'foto_url' => $fotoUrl,
        ]);
    }



}

?>