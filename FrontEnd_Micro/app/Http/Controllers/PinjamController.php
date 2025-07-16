<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class PinjamController extends Controller
{
    public function index(Request $request)
    {
        $token = session('token');
        $response = Http::get('http://localhost:8003/api/pinjam');
        $pinjams = $response->successful() ? $response->json() : [];
        
        $data = collect($response->json());

        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $perPage = 10;
        $currentItems = $data->slice(($currentPage - 1) * $perPage, $perPage)->values();

        $pinjams = new LengthAwarePaginator(
            $currentItems,
            $data->count(),
            $perPage,
            $currentPage,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        $breadcrumb = (object)[
            'title' => 'Daftar Peminjaman',
            'list' => ['Daftar Peminjaman']
        ];

        return view('pinjam.index', compact('pinjams', 'breadcrumb'))->with('activeMenu', 'pinjam');
    }

    public function create()
    {
        $bukus = Http::get("http://localhost:8003/api/buku")->json();

        $breadcrumb = (object)[
            'title' => 'Tambah Pinjam',
            'list' => ['Tambah Pinjam']
        ];

        return view('pinjam.create', compact('bukus', 'breadcrumb'))->with('activeMenu', 'pinjam');
    }

    private function getUserFromToken()
    {
        $token = session('token');

        if (!$token) {
            return null; // Token tidak ada di session
        }

        $response = Http::withToken($token)->get('http://localhost:8003/api/user');

        if ($response->successful()) {
            return $response->json(); // hasil: array ['user_id' => ..., 'nama' => ..., dst]
        }

        return null; // Gagal ambil user
    }

    public function store(Request $request)
    {
        $user = $this->getUserFromToken(); // Ambil data user

        if (!$user) {
            return back()->with('error', 'Gagal mendapatkan user');
        }


        $response = Http::withToken(session('token'))->post("http://localhost:8003/api/pinjam", [
            'user_id' => $user['user_id'], 
            'buku_id' => $request->buku_id,
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'tangga_kembali' => $request->tangga_kembali,

        ]);

        if ($response->successful()) {
            return redirect()->route('dashboard')->with('success', 'Data peminjaman berhasil disimpan');
        }
        return back()->with('error', 'Gagal menyimpan data');
    }


    public function show($id)
    {
        $breadcrumb = (object)[
            'title' => 'Detail Peminjaman',
            'list' => ['Peminjaman', 'Detail']
        ];

        $response = Http::get("http://localhost:8003/api/pinjam/{$id}");

        if ($response->successful()) {
            $pinjam = $response->json();
            $buku = Http::get("http://localhost:8003/api/buku/{$pinjam['buku_id']}")->json();
            $user = Http::get("http://localhost:8003/api/user/{$pinjam['user_id']}")->json();

            return view('pinjam.show', compact('pinjam', 'buku', 'user', 'breadcrumb'))->with('activeMenu', 'pinjam');
        }

        return redirect()->route('pinjam.index')->with('error', 'Data tidak ditemukan');
    }


}
