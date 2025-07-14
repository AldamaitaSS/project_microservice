<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PinjamModel;
use Illuminate\Support\Facades\Http;

class DashboardController extends Controller
{
    public function userPinjam($user_id)
    {
        $data = PinjamModel::orderBy('pinjam_id', 'desc')->take(5)->get();
        return response()->json($data);
    }

    public function adminPinjam()
{
    $pinjamList = PinjamModel::orderBy('pinjam_id', 'desc')->take(5)->get();

    $result = [];

    foreach ($pinjamList as $item) {
        // Ambil data user
        $userResponse = Http::get("http://localhost:8000/api/user/{$item->user_id}");
        $user = $userResponse->successful() ? $userResponse->json() : ['nama' => 'User tidak ditemukan'];

        // Ambil data buku
        $bukuResponse = Http::get("http://localhost:8001/api/buku/{$item->buku_id}");
        $buku = $bukuResponse->successful() ? $bukuResponse->json() : ['judul' => 'Buku tidak ditemukan'];

        // Gabungkan data
        $result[] = [
            'nama_user' => $user['nama'] ?? '-',
            'judul_buku' => $buku['judul'] ?? '-',
            'tanggal_pinjam' => $item->tanggal_pinjam,
            'tangga_kembali' => $item->tangga_kembali,
        ];
    }

    return response()->json($result);
}
}
