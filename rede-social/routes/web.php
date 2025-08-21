<?php
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

Route::get('/login',[LoginController::class, 'index']);

Route::fallback(function(){
    return "Erro ao localizar a rota!";
});