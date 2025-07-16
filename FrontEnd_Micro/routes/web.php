<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\PinjamController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\RiwayatController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/register', [AuthController::class, 'showRegister'])->name('register.form');
Route::post('/register', [AuthController::class, 'handleRegister'])->name('register.submit');
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'handleLogin']);
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/user', function (Request $request) {
    $token = $request->bearerToken();

    $response = Http::withToken($token)
        ->get('http://localhost:8000/api/user');

    return response($response->body(), $response->status());
});

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');


//buku
Route::group(['prefix' => 'buku'], function () {
    Route::get('/', [BukuController::class, 'index']);
    Route::get('/create', [BukuController::class, 'create']);
    Route::post('/', [BukuController::class, 'store']);
    Route::get('/{id}', [BukuController::class, 'show']);
    Route::get('/{id}/edit', [BukuController::class, 'edit']);
    Route::put('/{id}', [BukuController::class, 'update']);
    Route::delete('/{id}', [BukuController::class, 'destroy']);
});

Route::group(['prefix' => 'pinjam'], function () {
    Route::get('/', [PinjamController::class, 'index']);
    Route::get('/create', [PinjamController::class, 'create']);
    Route::post('/', [PinjamController::class, 'store']);
    Route::get('/{id}', [PinjamController::class, 'show']);
    Route::get('/{id}/edit', [PinjamController::class, 'edit']);
    Route::put('/{id}', [PinjamController::class, 'update']);
    Route::delete('/{id}', [PinjamController::class, 'destroy']);
});

Route::group(['prefix' => 'kategori'], function () {
    Route::get('/', [KategoriController::class, 'index']);
    Route::get('/create', [KategoriController::class, 'create']);
    Route::post('/', [KategoriController::class, 'store']);
    Route::get('/{id}', [KategoriController::class, 'show']);
    Route::get('/{id}/edit', [KategoriController::class, 'edit']);
    Route::put('/{id}', [KategoriController::class, 'update']);
    Route::delete('/{id}', [KategoriController::class, 'destroy']);
});

Route::middleware('web')->group(function () {
    Route::get('/riwayat', [RiwayatController::class, 'index']);
});

