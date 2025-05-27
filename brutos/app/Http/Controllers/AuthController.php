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
      $senhaInput = $request->input('loginPassword');

      if (is_null($matricula) || is_null($senhaInput)) {
          return response()->json(['error' => 'Senha ou Login não informados'], 404);
      }

      $usuario = \DB::connection('paco')
          ->table('Gerencial.Tb_Usuarios')
          ->where('Mt_Usuario', $matricula)
          ->first();

      if (!$usuario) {
          return response()->json(['error' => 'Usuário não encontrado'], 404);
      }

      $senhaValidacao = \DB::connection('paco')
          ->table('Gerencial.Tb_Usuarios')
          ->where('Sn_Usuario', $usuario->Sn_Usuario)
          ->first();
      
      if (!$senhaValidacao) {
          return response()->json(['error' => 'Senha ou Usuário errados'], 401);
      }

      $dados = null;
      if ($senhaValidacao && $usuario) {
          $dados = \DB::connection('controle_pessoal')
              ->table('sc_bases.tb_empregados')
              ->where('matricula', $matricula)
              ->first();
      }

      if ($senhaValidacao && $usuario) {
          // 🔐 Armazena na sessão
          session([
              'matricula' => $matricula,
              'senha_digitada' => $senhaInput,
              'hash_armazenado' => $usuario->Sn_Usuario,
              'dados' => $dados
          ]);

          return response()->json([
              'message' => 'Login bem-sucedido e dados armazenados na sessão.'
          ], 200);
      }
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