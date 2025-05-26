<?php

namespace App\Models;

use App\models\View_Colaborador;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
// use Tymon\JWTAuth\Contracts\JWTSubject;

// class User extends Authenticatable implements JWTSubject
 class User extends Authenticatable
{
    use Notifiable;

    public $timestamps = false;
    protected $table = 'public.tb_usuario';
    protected $primaryKey = 'co_usuario';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
      'co_usuario',
      'matricula',
      'senha',
      'co_perfil',
      'dt_criacao',
      'mat_criacao',
      'dt_alteracao',
      'mat_alteracao',
      'ic_ativo'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [

        'senha'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    /*protected $casts = [
        'email_verified_at' => 'datetime',
    ];*/


    public function getAuthPassword()
    {
        return Hash::make($this->senha) ;
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function getUser()
    {
        return User::from('public.tb_usuario as user')
        ->select(
            'user.co_usuario',
            'user.matricula',
            'user.senha',
            'user.co_perfil',
            'user.dt_criacao',
            'user.mat_criacao',
            'user.dt_alteracao',
            'user.mat_alteracao',
            'user.ic_ativo',
            'emp.nome'
        )
        ->join('sc_bases.tb_empregados as emp', 'user.matricula', '=', 'emp.matricula')
        ->where('user.matricula', $this->matricula)
        ->first();
    }

    public function resetPassword($matricula, $senha)
    {
        date_default_timezone_set('america/sao_paulo');

        if (User::where('matricula', $matricula)->exists()
            && $senha != '1ae765da44b163c8d6cb8051bc35192b') { // A senha está com criptografia, esse valor é do hash da plansul123.

            User::where('matricula', $matricula)
            ->update([
                'senha' => $senha,
                'dt_alteracao' => date('Y-m-d H:i', time()),
            ]);
        } else {
            
            return response()->json([
                "message" => "New password cannot be the same password default"
            ], 409);
        }

        return response()->json([
            "massege" => "update successfully"
        ], 200);
    }

    public function comparePassword($matricula, $senhaAtual, $senhaAtualSemHash)
    {
        $getLoginSenha = User::select('senha')
                             ->where('matricula', $matricula)
                             ->first();
        
        $senhaBaseEncoded = base64_encode($senhaAtualSemHash);

        if ($senhaAtual == $getLoginSenha["senha"]) {
            return $senhaBaseEncoded;
        } else {
            return $senhaBaseEncoded; // Em caso de redefinir a própria senha.
        }
    }

public function validateForPassportPasswordGrant($password)
{
    return md5($password) === $this->senha;
}


}
