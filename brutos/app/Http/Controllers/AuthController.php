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
    
        $response = Http::post('http://172.32.1.73:9910/login', [
            'matricula' => $matricula,
            'senha' => $senha,
            'api_key' => 'DVtLwuTJv83QWGPzJKPEi'
        ]);
        
        // Mesmo que a API responda com erro, captura o conteúdo
        $data = $response->json(); 
        
        if ($response->status() !== 200) {
            return response()->json([
                'error' => 'Erro retornado pela API externa.',
                'api_status' => $response->status(),
                'api_response' => $data
            ], $response->status());
        }
        
        if (!isset($data['status']) || $data['status'] !== 'success') {
            return response()->json([
                'error' => $data['message'] ?? 'Credenciais inválidas.',
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
    
        return response()->json([
            'message' => 'Login autorizado pela API e dados carregados.',
            'dados' => $dados
        ], 200);
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