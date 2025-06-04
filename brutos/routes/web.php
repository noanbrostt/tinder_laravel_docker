<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\InscricaoController;
use App\Http\Controllers\ValidarInscricao;


Route::middleware(['web'])
    // ->prefix(ltrim(env('PREFIX', ''), '/') . '/')
    ->group(function () {

        Route::get('/home', function () {
            return view('welcome');
        });

        Route::get('/', function () {
            return redirect()->route('login');
        });

        // Testa conexão com banco principal (pgsql)
        Route::get('/teste-principal', function () {
            try {
                $resultado = DB::connection('tinder2')->select('SELECT datname from pg_database');
                return response()->json([
                    'status' => 'Conexão principal bem-sucedida!',
                    'hora_atual' => $resultado ?? 'sem retorno'
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'status' => 'Erro na conexão principal',
                    'mensagem' => $e->getMessage()
                ], 500);
            }
        });

        Route::get('/teste-tinder', function () {
           try {
                $resultado = DB::connection('tinder2')
                    ->table('public.usuario')
                    ->where('matricula', 123582)
                    ->delete();

       
               return response()->json([
                   'status' => 'Conexão e acesso à tabela "usuario" bem-sucedido!',
                   'dados' => $resultado
               ]);
           } catch (\Exception $e) {
               return response()->json([
                   'status' => 'Erro ao acessar a tabela usuario',
                   'mensagem' => $e->getMessage()
               ], 500);
           }
        });

        // Testa conexão com banco secundário (controle_pessoal) + leitura da tabela
        Route::get('/teste-tb_usuario', function () {
            try {
                $resultado = DB::connection('controle_pessoal')
                    ->table('tb_usuario') // Aspas duplas para respeitar o case da tabela
                    ->select('matricula', 'ic_ativo') // seleciona campos simples
                    ->limit(1)
                    ->get();

                return response()->json([
                    'status' => 'Conexão e leitura da tabela tb_usuario bem-sucedida!',
                    'amostra' => $resultado
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'status' => 'Erro ao acessar a tabela tb_usuario',
                    'mensagem' => $e->getMessage()
                ], 500);
            }
        });




        // Testa conexão com banco secundário (controle_pessoal)
        Route::get('/teste-controle', function () {
            try {
                $resultado = DB::connection('controle_pessoal')->select('SELECT NOW()');
                return response()->json([
                    'status' => 'Conexão controle_pessoal bem-sucedida!',
                    'hora_atual' => $resultado[0]->now ?? 'sem retorno'
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'status' => 'Erro na conexão controle_pessoal',
                    'mensagem' => $e->getMessage()
                ], 500);
            }
        });

        Route::get('/teste-paco', function () {
            try {
                $resultado = DB::connection('paco')->select('SELECT NOW()');
                return response()->json([
                    'status' => 'Conexão com banco paco bem-sucedida!',
                    'hora_atual' => $resultado[0]->now ?? 'sem retorno'
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'status' => 'Erro na conexão com banco paco',
                    'mensagem' => $e->getMessage()
                ], 500);
            }
        });

        Route::get('/login', function () {
            return view('login');
        });
        Route::post('/login', [AuthController::class, 'login'])->name('login');

        Route::post('/trocar_senha', [AuthController::class, 'trocarSenha']);
        Route::post('/resetarSenha', [AuthController::class, 'resetarSenha'])->name('resetarSenha');

        Route::get('/inscricao', [InscricaoController::class, 'home'])->name('inscricao');
        Route::post('/inscricao', [InscricaoController::class, 'store'])->name('inscricao.store');

        Route::get('/validar', function () {
            return view('validar');
        })->name('validar');
        Route::get('/validar/listar', [ValidarInscricao::class, 'listarInscricoes'])->name('validar.listar');
        Route::post('/validar/atualizar', [ValidarInscricao::class, 'atualizarInscricao'])->name('validar.atualizar');
        Route::get('/tinder', function () {
            return view('tinder');
        })->name('tinder');

    });



