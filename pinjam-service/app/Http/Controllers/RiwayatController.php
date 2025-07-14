<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PinjamModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class RiwayatController extends Controller
{
    public function index($id)
    {
        $pinjamans = PinjamModel::where('user_id', $id)->get();
        $bukuResponse = Http::get('http://localhost:8001/api/buku');
        $bukuList = $bukuResponse->successful() ? collect($bukuResponse->json()) : collect();

        $data = $pinjamans->map(function ($item) use ($bukuList) {
           $buku = $bukuList->firstWhere('buku_id', $item->buku_id);
            $judul = $buku['judul'] ?? 'Tidak diketahui';

            logger("Buku ID: {$item->buku_id}");
logger($bukuList->pluck('buku_id'));


            $tanggalPinjam = Carbon::parse($item->tanggal_pinjam);
            $tanggalKembali = $item->tanggal_kembali 
                            ? Carbon::parse($item->tanggal_kembali)
                            : null;
            $batas = $tanggalPinjam->copy()->addDays(7);
            $hariIni = Carbon::now();

            if ($tanggalKembali) {
                $status = 'Selesai';
            } elseif ($hariIni->gt($batas)) {
                $status = 'Terlambat ' . $hariIni->diffInDays($batas) . ' hari';
            } else {
                $status = 'Sisa ' . $hariIni->diffInDays($batas) . ' hari';
            }

            return [
                'judul' => $judul,
                'buku_id' => $item->buku_id,
                'tanggal_pinjam' => $item->tanggal_pinjam,
                'tanggal_kembali' => $item->tangga_kembali,
                'status' => $status,
            ];
        });

        return response()->json($data);
    }
}