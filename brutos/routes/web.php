<?php

use Illuminate\Support\Facades\Route;

// Route::middleware(['web'])->prefix(trim(env('PREFIX', ''), '/'))->group(function () {
  

//teste 



Route::middleware(['web'])
    ->prefix(ltrim(env('PREFIX', ''), '/'))
    ->group(function () {
        Route::get('/home', function () {
            return view('welcome');
        });
    });


?>
