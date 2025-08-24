<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;

// Auth
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'store'])->name('login.store');

Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [RegisterController::class, 'store'])->name('register.store');

Route::get('/forgot-password', [ForgotPasswordController::class, 'showForgotForm'])->name('password.request');
Route::post('/forgot-password', [ForgotPasswordController::class, 'updatePassword'])->name('password.update');

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('/events', fn() => view('home.events'))->name('events');
Route::get('/profile', [ProfileController::class, 'showContent'])->name('profile');
Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');


Route::middleware('auth')->group(function () {
    Route::get('/events-data', [EventController::class, 'index'])->name('events.data');
    Route::post('/events', [EventController::class, 'store'])->name('events.store');
    Route::post('/events/{id}/interested', [EventController::class, 'interested'])->name('events.interested');
});



// Dashboard protegido
Route::get('/dashboard', function () {
    return 'Bem-vindo ao dashboard!';
})->middleware('auth')->name('dashboard');
