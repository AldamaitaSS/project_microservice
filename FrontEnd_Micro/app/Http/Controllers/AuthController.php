<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function showRegister()
    {
        return view('auth.register');
    }

    public function handleRegister(Request $request)
    {
        $response = Http::post('http://localhost:8003/api/register', [
            'nama' => $request->nama,
            'username' => $request->username,
            'password' => $request->password,
        ]);

        if ($response->successful()) {
            return redirect()->route('login')->with('message', 'Registrasi berhasil, silakan login.');
        }

        $request->validate([
            'nama' => 'required|string|max:255',
            'username' => 'required|string|max:255',
            'password' => 'required|string|min:6',
        ]);
        return back()->withErrors(['register' => 'Registrasi gagal']);
    }

    public function showLogin()
    {
        return view('auth.login');
    }

    public function handleLogin(Request $request)
    {
        // Log untuk memastikan masuk
        Log::info('HandleLogin terpanggil', ['request' => $request->all()]);

        $response = Http::post('http://localhost:8003/api/login', [
            'username' => $request->username,
            'password' => $request->password,
        ]);

        // dd([
        //     'status' => $response->status(),
        //     'json' => $response->json()
        // ]);

        // Log::info('Login response', ['body' => $response->json()]);

        // if ($response->successful()) {
        //     $user = $response['user'] ?? null;
        //     $token = $response['token'] ?? null;
        //     $level = $response['level'] ?? null;

        //     if ($user && $token) {
        //         $data = $response->json();
        //         session([
        //             'user_id' => $user['user_id'] ?? null,
        //             'token' => $token,
        //             'level_id' => $user['level_id'] ?? null,
        //         ]);
            $user = $response['user'] ?? null;
            $token = $response['token'] ?? null;

            if ($user && $token) {
                $data = $response->json();
                session([ 
                    'user_id' => $user['user_id'] ?? null,
                    'token' => $token,
                    'level_id' => $user['level_id'] ?? null, // ambil dari $user langsung
                ]);

                return redirect()->route('dashboard');
            }
        

        return redirect()->back()->withErrors([
            'username' => 'Username atau password salah.',
        ]);
    }
    private function getUserFromToken()
    {
        $token = session('token');

        $response = Http::withToken($token)->get('http://localhost:8003/api/user'); // API Gateway

        if ($response->successful()) {
            return $response->json();
        }
        return null;
    }
    
    

    public function dashboard()
    {
        return view('dashboard');
    }

    public function logout(Request $request)
    {
        $token = session('token');
        session()->forget(['token', 'user_id', 'level_id']);

        $response = Http::withToken($token)->post('http://localhost:8003/api/logout');

        if ($response->successful()) {
            session()->forget('token'); // hapus token dari session
            return redirect()->route('login')->with('message', 'Logout berhasil');
        } else {
            return back()->withErrors(['logout' => 'Logout gagal']);
        }
    }

}
