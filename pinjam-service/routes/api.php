<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PinjamController;
use App\Http\Controllers\RiwayatController;
use App\Http\Controllers\DashboardController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::middleware('api')->group(function () {
    Route::get('/pinjam', [PinjamController::class, 'index']);
    Route::get('/pinjam/cek-kembali-otomatis', [PinjamController::class, 'cekPengembalianOtomatis']);
    Route::get('/pinjam/{id}', [PinjamController::class, 'show']);
    Route::post('/pinjam', [PinjamController::class, 'store']);
    Route::put('/pinjam/{id}', [PinjamController::class, 'update']);
    Route::delete('/pinjam/{id}', [PinjamController::class, 'destroy']);

    Route::get('/riwayat/{id}', [RiwayatController::class, 'index']);

    Route::get('/dashboard-user/{user_id}', [DashboardController::class, 'userPinjam']);
    Route::get('/dashboard-admin', [DashboardController::class, 'adminPinjam']);


});



