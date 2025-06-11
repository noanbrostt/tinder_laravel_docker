<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\InscricaoController;
use App\Http\Controllers\InteracoesController;
use App\Http\Controllers\ValidarInscricao;


Route::middleware(['web'])
    ->group(function () {

        Route::get('/home', function () {
            return view('welcome');
        });

        Route::get('/', function () {
            return redirect()->route('login');
        });


        Route::get('/login', function () {
            return view('login');
        });

        Route::post('/login', [AuthController::class, 'login'])->name('login');
        Route::post('/trocar_senha', [AuthController::class, 'trocarSenha']);
        Route::post('/resetarSenha', [AuthController::class, 'resetarSenha'])->name('resetarSenha');
        Route::any('/lista', [AuthController::class, 'lista']);

        Route::get('/inscricao', [InscricaoController::class, 'home'])->name('inscricao');
        Route::post('/inscricao', [InscricaoController::class, 'store'])->name('inscricao.store');

        Route::get('/validar', [ValidarInscricao::class, 'home'])->name('validar');
        Route::get('/validar/listar', [ValidarInscricao::class, 'listarInscricoes'])->name('validar.listar');
        Route::post('/validar/atualizar', [ValidarInscricao::class, 'atualizarInscricao'])->name('validar.atualizar');
        Route::get('/validar/contarUsuariosPorStatus', [ValidarInscricao::class, 'contarUsuariosPorStatus'])->name('validar.contarUsuariosPorStatus');

        Route::get('/tinder', [InteracoesController::class, 'index'])->name('tinder');
        Route::post('/interacoes', [InteracoesController::class, 'store'])->name('reagir');
        
        Route::get('/matchs', [InteracoesController::class, 'listarLikes'])->name('listarLikes');
    });



