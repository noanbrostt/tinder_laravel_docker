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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use App\Models\User;
use App\Models\View_Colaborador;



use function PHPUnit\Framework\isEmpty;

class AuthController extends Controller
{


    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth:api', ['except' => ['login', 'reset']]);
    }
    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
public function login(Request $request)
{
    $matricula = $request->input('loginMatricula');
    $senhaInput = $request->input('loginPassword');

    if (!$matricula || !$senhaInput) {
        return response()->json(['error' => 'Credenciais ausentes'], 400);
    }

    // Criptografa senha com md5 (igual ao banco)
    $senhaCriptografada = md5($senhaInput);

    // Busca usuário manualmente
    $usuario = \DB::connection('controle_pessoal')
        ->table('tb_usuario')
        ->where('matricula', $matricula)
        ->where('senha', $senhaCriptografada)
        ->where('ic_ativo', 1)
        ->first();

    if (!$usuario) {
        return response()->json(['error' => 'Usuário ou senha incorretos'], 401);
    }

    // Opcional: força reset se senha for padrão
    if ($senhaInput === 'plansul123') {
        return response()->json(['error' => 'Reset Password'], 403);
    }

    // Gera token manualmente com claims personalizados (se estiver usando JWT)
    $token = auth()->login(new \App\Models\User([
        'matricula' => $usuario->matricula,
        'senha' => $usuario->senha
    ]));

    return $this->respondWithToken($token);
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

