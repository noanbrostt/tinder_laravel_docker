<?php
/**
 * Controller responsavel pela autenticação.
 *
 *
 */

namespace App\Http\Controllers;

 use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

use App\Models\User;
use App\Models\View_Colaborador;



// use function PHPUnit\Framework\isEmpty;

class AuthController extends Controller {


    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        // O método middleware() é herdado da classe base Controller do Laravel.
        // $this->middleware('auth:api', ['except' => ['login', 'reset']]);
    }
    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */

    public function login(Request $request){

        $matricula = $request->input('loginMatricula');
        $senha = $request->input('loginPassword');
    
        if (is_null($matricula) || is_null($senha)) {
            return response()->json(['error' => 'Matrícula e senha são obrigatórias.'], 400);
        }
    
        $cadastro = DB::connection('tinder2')
        ->table('public.usuario')
        ->leftJoin('public.motivo_recusa', 'public.usuario.id_motivo_recusa', '=', 'public.motivo_recusa.id_motivo_recusa')
        ->where('public.usuario.matricula', $matricula)
        ->select('public.usuario.*', 'public.motivo_recusa.no_motivo_recusa')
        ->first();



        $response = Http::post('http://172.32.1.73:9910/login', [
            'matricula' => $matricula,
            'senha' => $senha,
            'api_key' => 'DVtLwuTJv83QWGPzJKPEi'
        ]);

        // Mesmo que a API responda com erro, captura o conteúdo
        $data = $response->json(); 
        
        if ($response->status() !== 200) {
            return response()->json([
                'error' => $response->status() === 401 ? 'Senha incorreta.' : 'Matrícula não encontrada, cadastra-se em "Criar Senha".',
                'api_status' => $response->status(),
                'api_response' => $data
            ], $response->status());
        }
        
        if (!isset($data['status']) || $data['status'] !== 'success') {
            return response()->json([
                'error' => $data['message'] ?? 'Não autorizado.',
                'api_status' => 401,
                'api_response' => $data
            ], 401);
        }

        // Busca dados adicionais no banco local
        $dados = \DB::connection('controle_pessoal')
            ->table('sc_bases.tb_empregados')
            ->where('matricula', $matricula)
            ->first();
    
        // Armazena na sessão
        session([
            'matricula' => $matricula,
            'dados' => $dados,
            'resposta_api' => $data // opcional: guarda a resposta da API
        ]);

        if ($cadastro) { // varifica se já está cadstrado
            $possuiCadastro = true;
        } else {
            $possuiCadastro = false;
        }

        return response()->json([
                'success' => true,
                'redirect' => route('inscricao'),
                'possuiCadastro' => $possuiCadastro,
                'cadastro' => $cadastro,
                'dados' => $dados,
            ]);

    }

        public function trocarSenha(Request $request) {

            if (!$this->validarApiKey($request->input('api_key'))) {
                return response()->json(['error' => 'API key inválida'], 401);
            }
    
            $usuario = DB::table('usuario')->where('matricula', $request->input('matricula'))->first();
    
            if (!$usuario || !Hash::check($request->input('senha_atual'), $usuario->senha)) {
                return response()->json(['error' => 'Senha atual incorreta'], 401);
            }
    
            DB::table('usuario')
                ->where('matricula', $request->input('matricula'))
                ->update([
                    'senha' => Hash::make($request->input('nova_senha')),
                    'dh_alteracao' => now()
                ]);
    
            return response()->json(['message' => 'Senha alterada com sucesso']);
        }
    
        public function resetarSenha(Request $request){

            $matricula = $request->input('matricula');
            $cpf = $request->input('cpf');
            $nova_senha = $request->input('nova_senha');
        
            if (is_null($cpf) || is_null($nova_senha)||is_null($matricula) ) {
                return response()->json(['error' => 'CPF, matricula e nova senha são obrigatórios.'], 400);
            }
        
            $response = Http::post('http://172.32.1.73:9910/resetar_senha', [
                'cpf' => $cpf,
                'nova_senha' => $nova_senha,
                'api_key' => 'DVtLwuTJv83QWGPzJKPEi'
            ]);
        
            $data = $response->json();
        
            if ($response->status() !== 200) {
                return response()->json([
                    'error' => $response->status() === 401 ? 'Não autorizado pela API.' : 'CPF não encontrado.',
                    'api_status' => $response->status(),
                    'api_response' => $data,
                    'cpf' => $cpf,
                    'nova_senha' => $nova_senha
                ], $response->status());
            }
        
            if (!isset($data['status']) || $data['status'] !== 'success') {
                return response()->json([
                    'error' => $data['message'] ?? 'Erro.',
                    'api_status' => 400,
                    'api_response' => $data
                ], 400);
            }
        
            $cadastro = DB::connection('tinder2')
            ->table('public.usuario')
            ->leftJoin('public.motivo_recusa', 'public.usuario.id_motivo_recusa', '=', 'public.motivo_recusa.id_motivo_recusa')
            ->where('public.usuario.matricula', $matricula)
            ->select('public.usuario.*', 'public.motivo_recusa.no_motivo_recusa')
            ->first();

            $dados = \DB::connection('controle_pessoal')
            ->table('sc_bases.tb_empregados')
            ->where('matricula', $matricula)
            ->first();
                       
            session([ // Armazena na sessão
                'matricula' => $matricula,
                'dados' => $dados,
                'resposta_api' => $data 
            ]);

            if ($cadastro) { // varifica se já está cadstrado
                $possuiCadastro = true;
            } else {
                $possuiCadastro = false;
            }

            return response()->json([
                'success' => true,
                'redirect' => route('inscricao'),
                'possuiCadastro' => $possuiCadastro,
                'cadastro' => $cadastro,
                'dados' => $dados,
            ]);
        }




    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        $user = auth('api')->user()->getUser();
        return response()->json($user);
    }

    /**
     * Update User Login Password.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function reset(Request $request)
    {
        $user = new User();

        $senha =  md5($request->input('loginPassword'));
        $matricula = $request->input('loginMatricula');

        return $user->resetPassword($matricula, $senha);
    }

    /**
     * Update Own User Login Password.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getOwnPassword(Request $request)
    {
        $user = new User();

        $senha = md5($request->input('novaSenha'));
        $matricula = $request->input('loginMatricula');

        return $user->resetPassword($matricula, $senha);
    }

    /**
     * Update User Login Password.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function confirmPassword(Request $request)
    {
        $getMatricula = new View_Colaborador;
        $user = new User();

        $getMatricula = $getMatricula->getAuthUser();
        $matricula = $getMatricula[0]->matricula;

        $senhaAtualSemHash = $request->input('loginPassword');
        $senhaAtual = md5($request->input('loginPassword'));
        
        return $user->comparePassword($matricula, $senhaAtual, $senhaAtualSemHash);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth('api')->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth('api')->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::factory()->getTTL() * 60
        ]);
    }

}
