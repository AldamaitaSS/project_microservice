<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;

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

//login
Route::post('/register', function (Request $request) {
    $response = Http::post('http://localhost:8000/api/register', $request->all());
    return response($response->body(), $response->status());
});
Route::post('/login', function (Request $request) {
    $response = Http::post('http://localhost:8000/api/login', $request->all());
    return response($response->body(), $response->status());
});
Route::get('/user', function (Request $request) {
    $token = $request->bearerToken();

    $response = Http::withToken($token)
        ->get('http://localhost:8000/api/user');

    return response($response->body(), $response->status());
});
Route::get('/user/{id}', function ($id, Request $request) {
    $token = $request->bearerToken();

    $response = Http::withToken($token)
        ->get("http://localhost:8000/api/user/{$id}");

    return response($response->body(), $response->status())
        ->header('Content-Type', $response->header('Content-Type'));
});
Route::post('/logout', function (Request $request) {
    $token = $request->bearerToken();

    $response = Http::withToken($token)->post('http://localhost:8000/api/logout');
});


//buku
Route::prefix('buku')->group(function () {
    Route::get('/search', function (Request $request) {
        logger('API Gateway menerima pencarian', ['keyword' => $request->query('q')]);
        $search = $request->query('q');
        $response = Http::get('http://localhost:8001/api/buku/search', [
            'search' => $search
        ]);

        return response($response->body(), $response->status())
            ->header('Content-Type', $response->header('Content-Type'));
    });
    Route::get('/', function () {
        return Http::get('http://localhost:8001/api/buku')->json();
    });
    Route::get('{id}', function ($id) {
        return Http::get("http://localhost:8001/api/buku/{$id}")->json();
    });
    Route::post('/', function (Request $request) {
        return Http::post('http://localhost:8001/api/buku', $request->all())->json();
    });
    Route::put('{id}', function (Request $request, $id) {
        return Http::put("http://localhost:8001/api/buku/{$id}", $request->all())->json();
    });
    Route::put('/kurangi-stok/{id}', function ($id) {
        return Http::put("http://localhost:8001/api/buku/kurangi-stok/{$id}")->json();
    });
    Route::delete('{id}', function ($id) {
        return Http::delete("http://localhost:8001/api/buku/{$id}")->json();
    });
    Route::put('/tambah-stok/{id}', function ($id) {
        return Http::put("http://localhost:8001/api/buku/tambah-stok/{$id}")->json();
    });

    
});


//pinjam
Route::prefix('pinjam')->group(function () {
    // GET semua data
    Route::get('/', function () {
        $response = Http::get('http://localhost:8002/api/pinjam');
        return response($response->body(), $response->status())
            ->header('Content-Type', $response->header('Content-Type'));
    });
    // GET by ID
    Route::get('{id}', function ($id) {
        return Http::get("http://localhost:8002/api/pinjam/{$id}")->json();
    });
    // POST data baru
    Route::post('/', function (Request $request) {
        $token = $request->bearerToken();
        $response = Http::withToken($token)
            ->post('http://localhost:8002/api/pinjam', $request->all());
        return response($response->body(), $response->status())
            ->header('Content-Type', $response->header('Content-Type'));
    });
    // PUT update
    Route::put('{id}', function (Request $request, $id) {
        return Http::put("http://localhost:8002/api/pinjam/{$id}", $request->all())->json();
    });
    // DELETE data
    Route::delete('{id}', function ($id) {
        return Http::delete("http://localhost:8002/api/pinjam/{$id}")->json();
    });
    Route::get('/cek-kembali-otomatis', function () {
        return Http::get("http://localhost:8002/api/pinjam/cek-kembali-otomatis")->json();
    });

});


//kategori
Route::prefix('kategori')->group(function () {
    Route::get('/', function () {
        return Http::get('http://localhost:8001/api/kategori')->json();
    });
    Route::get('{id}', function ($id) {
        return Http::get("http://localhost:8001/api/kategori/{$id}")->json();
    });
    Route::post('/', function (Request $request) {
        return Http::post('http://localhost:8001/api/kategori', $request->all())->json();
    });
    Route::put('{id}', function (Request $request, $id) {
        return Http::put("http://localhost:8001/api/kategori/{$id}", $request->all())->json();
    });
    Route::delete('{id}', function ($id) {
        return Http::delete("http://localhost:8001/api/kategori/{$id}")->json();
    });
});

Route::get('/riwayat/{id}', function ($id) {
    $token = request()->bearerToken(); // Optional, kalau pakai auth

    $res = Http::withToken($token)
        ->get("http://localhost:8002/api/riwayat/$id");

    return response($res->body(), $res->status())
            ->header('Content-Type', $res->header('Content-Type'));
});


Route::get('/dashboard-admin', function (Request $request) {
    $token = $request->bearerToken();

    $users = Http::withToken($token)->get('http://localhost:8000/api/dashboard-data');
    $pinjam = Http::withToken($token)->get('http://localhost:8002/api/dashboard-admin');

    return response()->json([
        'recent_users' => $users->json()['recent_users'] ?? [],
        'recent_pinjam' => $pinjam->json() ?? []
    ]);
});


Route::get('/dashboard-user/{id}', function ($id, Request $request) {
    $token = $request->bearerToken();

    $pinjam = Http::withToken($token)->get("http://localhost:8002/api/dashboard-user/{$id}");

    return response()->json([
        'pinjam' => $pinjam->json()
    ]);
});
