<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Pagination\LengthAwarePaginator;

class BukuController extends Controller
{
    public function index(Request $request)
    {
        $response = Http::get('http://localhost:8003/api/buku');
        $bukus = $response->successful() ? $response->json() : [];
        $data = collect($response->json());

        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $perPage = 10;
        $currentItems = $data->slice(($currentPage - 1) * $perPage, $perPage)->values();

        $bukus = new LengthAwarePaginator(
            $currentItems,
            $data->count(),
            $perPage,
            $currentPage,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        $breadcrumb = (object)[
            'title' => 'Daftar Buku',
            'list' => ['Daftar Buku']
        ];

        return view('buku.index', compact('bukus', 'breadcrumb'))->with('activeMenu', 'buku');
    }

    public function create()
    {
        $breadcrumb = (object)[
            'title' => 'Tambah Buku',
            'list' => ['Tambah Buku']
        ];
        
        $response = Http::get('http://localhost:8003/api/kategori');
        $kategoris = $response->successful() ? $response->json() : [];

        return view('buku.create', compact('kategoris', 'breadcrumb'))->with('activeMenu', 'buku');
    }

    public function store(Request $request)
    {
        $data = $request->only(['judul', 'penulis', 'stok', 'kategori_id']);

        $response = Http::post('http://localhost:8003/api/buku', $data);

        if ($response->successful()) {
            return redirect('/buku')->with('success', 'Buku berhasil ditambahkan!');
        } else {
            return redirect('/buku/create')->with('error', 'Gagal menambahkan buku.');
        }
    }

    public function show($id)
    {
        $breadcrumb = (object)[
            'title' => 'Detail Buku',
            'list' => ['Detail Buku']
        ];

        $response = Http::get("http://localhost:8003/api/buku/{$id}");

        if (!$response->successful() || empty($response->json())) {
            return redirect('/buku')->with('error', 'Data buku tidak ditemukan.');
        }
        

        $buku = $response->json();
        return view('buku.show', compact('buku', 'breadcrumb'))->with('activeMenu', 'buku');
    }

    public function edit($id)
    {
        $breadcrumb = (object)[
            'title' => 'Edit Buku',
            'list' => ['Edit Buku']
        ];

        $resBuku = Http::get("http://localhost:8003/api/buku/{$id}");
        $resKategori = Http::get("http://localhost:8003/api/kategori");

        if (!$resBuku->successful() || empty($resBuku->json())) {
            return redirect('/buku')->with('error', 'Data buku tidak ditemukan.');
        }

        $buku = $resBuku->json();
        $kategoris = $resKategori->successful() ? $resKategori->json() : [];

        return view('buku.edit', compact('buku', 'kategoris', 'breadcrumb'))->with('activeMenu', 'buku');
    }

    public function update(Request $request, $id)
    {
        $data = $request->only(['judul', 'penulis', 'stok', 'kategori_id']);

        $res = Http::put("http://localhost:8003/api/buku/{$id}", $data);

        if ($res->successful()) {
            return redirect('/buku')->with('success', 'Buku berhasil diperbarui!');
        } else {
            return redirect("/buku/{$id}/edit")->with('error', 'Gagal memperbarui buku.');
        }
    }

    public function destroy($id)
    {
        Http::delete("http://localhost:8003/api/buku/{$id}");
        return redirect('/buku')->with('success', 'Buku berhasil dihapus!');
    }
}
