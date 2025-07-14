<?php

use Illuminate\Http\Request;
use App\Models\UserModel;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
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
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/user', [AuthController::class, 'user']); 
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user-from-token', [AuthController::class, 'getUserFromToken']);
    Route::get('/user/{id}', [AuthController::class, 'getUserById']);
    Route::get('/dashboard-data', [DashboardController::class, 'index']);

});



