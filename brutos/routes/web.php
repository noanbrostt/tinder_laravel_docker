<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

Route::middleware(['web'])
    ->prefix(ltrim(env('PREFIX', ''), '/') . '/')
    ->group(function () {

        Route::get('/home', function () {
            return view('welcome');
        });

        // Testa conexão com banco principal (pgsql)
        Route::get('/teste-principal', function () {
            try {
                $resultado = DB::connection('pgsql')->select('SELECT NOW()');
                return response()->json([
                    'status' => 'Conexão principal bem-sucedida!',
                    'hora_atual' => $resultado[0]->now ?? 'sem retorno'
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'status' => 'Erro na conexão principal',
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

    });

?>
