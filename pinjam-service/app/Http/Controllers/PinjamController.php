<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PinjamModel;
use Illuminate\Support\Facades\Http;
use Tymon\JWTAuth\Facades\JWTAuth;

class PinjamController extends Controller
{
    public function index()
    {
        $pinjams = PinjamModel::all();
        $data = [];

        foreach ($pinjams as $pinjam) {
            // Ambil data buku dari buku-service
            $buku = Http::get("http://localhost:8001/api/buku/{$pinjam->buku_id}")->json();

            // Ambil data user dari auth-service
            $user = Http::get("http://localhost:8000/api/user/{$pinjam->user_id}")->json();

            $data[] = [
                'pinjam_id' => $pinjam->pinjam_id,
                'user_id' => $pinjam->user_id,
                'nama_user' => $user['nama'] ?? 'Tidak ditemukan',
                'buku_id' => $pinjam->buku_id,
                'judul_buku' => $buku['judul'] ?? 'Tidak ditemukan',
                'tanggal_pinjam' => $pinjam->tanggal_pinjam,
                'tangga_kembali' => $pinjam->tangga_kembali,
                'status' => $pinjam->status,
            ];
        }

        return response()->json($data);
    }

    public function show($id)
    {
        return response()->json(PinjamModel::findOrFail($id));
    }

    public function store(Request $request)
    {
        // Http::get("http://localhost:8002/api/pinjam/cek-pengembalian-otomatis");

        $token = $request->bearerToken();

        if (!$token) {
            return response()->json(['message' => 'Token tidak ditemukan'], 401);
        }

        $userResponse = Http::withToken($token)->get('http://localhost:8000/api/user');

        if (!$userResponse->ok()) {
            return response()->json(['message' => 'Token tidak valid'], 401);
        }

        $user = $userResponse->json();

        $request->validate([
            'buku_id' => 'required|integer',
            'tanggal_pinjam' => 'required|date',
            'tangga_kembali' => 'required|date|after_or_equal:tanggal_pinjam',
        ]);

        $buku = Http::get("http://localhost:8001/api/buku/{$request->buku_id}")->json();

        if (!$buku || isset($buku['message'])) {
            return response()->json(['message' => 'Buku tidak ditemukan'], 404);
        }

        if ($buku['stok'] <= 0) {
            return response()->json(['message' => 'Stok buku habis'], 400);
        }

        $user = $userResponse->json();
        $pinjam = PinjamModel::create([
            'user_id' => $user['user_id'],
            'nama_user' => $user['nama'],
            'buku_id' => $request->buku_id,
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'tangga_kembali' => $request->tangga_kembali,
            'status' => 'dipinjam'
        ]);

        Http::put("http://localhost:8001/api/buku/kurangi-stok/{$request->buku_id}");


        return response()->json($pinjam, 201);
    }

    public function update(Request $request, $id)
    {
        $pinjam = PinjamModel::findOrFail($id);
        $pinjam->update($request->all());

        return response()->json($pinjam);
    }

    public function destroy($id)
    {
        PinjamModel::destroy($id);
        return response()->json(['message' => 'Data pinjam dihapus']);
    }

    public function cekPengembalianOtomatis()
    {
        $today = now()->toDateString();
        $pinjams = PinjamModel::where('status', 'dipinjam')
            ->whereDate('tangga_kembali', '<', $today)
            ->get();

        foreach ($pinjams as $pinjam) {
            // Update status ke "selesai"
            $pinjam->status = 'selesai';
            $pinjam->save();

            // Kembalikan stok buku via buku-service
            Http::put("http://localhost:8001/api/buku/tambah-stok/{$pinjam->buku_id}");
        }

        return response()->json(['message' => 'Proses pengembalian otomatis selesai', 'total' => $pinjams->count()]);
    }

}