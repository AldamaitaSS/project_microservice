<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserModel;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:m_user,username',
            'password' => 'required|string|min:6',
        ]);

        // Buat user baru
        $user = UserModel::create([
            'nama' => $request->nama,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'level_id' => 2 // default user level
        ]);

        return response()->json([
            'message' => 'Registrasi berhasil',
            'user' => $user
        ], 201);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('username', 'password');

        if (!$token = auth('api')->attempt($credentials)) {
            return response()->json(['message' => 'Username atau password salah'], 401);
        }
        $user = auth('api')->user();
        return response()->json([
            'token' => $token,
            'user' => [
                'user_id' => $user->user_id,
                'nama' => $user->nama,
                'username' => $user->username,
                'level_id' => $user->level_id, 
            ]
        ]);
    }

    public function getUserById($id)
    {
        $user = UserModel::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        return response()->json([
            'user_id' => $user->user_id,
            'nama' => $user->nama,
        ]);
    }

    public function getUserFromToken(Request $request)
    {
        try {
            if (! $user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['error' => 'User not found'], 404);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'Token invalid'], 401);
        }

        return response()->json([
            'user_id' => $user->id,
            'nama' => $user->nama,
            'username' => $user->username,
            'level_id' => $user->level_id
        ]);
    }

    public function user(Request $request)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
            return response()->json([
                'user_id' => $user->user_id,
                'nama' => $user->nama,
                'username' => $user->username,
                'level_id' => $user->level_id,
            ]);
        } catch (JWTException $e) {
            return response()->json(['error' => 'Token invalid', 'message' => $e->getMessage()], 401);
        }
    }

    public function logout(Request $request)
    {
        try {
            JWTAuth::invalidate(JWTAuth::getToken());

            return response()->json(['message' => 'Berhasil Logout']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal Logout', 'details' => $e->getMessage()], 500);
        }
    }

}
