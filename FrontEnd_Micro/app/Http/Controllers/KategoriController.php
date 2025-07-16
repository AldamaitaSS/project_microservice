<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class KategoriController extends Controller
{
    public function index(Request $request)
    {
        $response = Http::get('http://localhost:8003/api/kategori');
        $kategoris = $response->successful() ? $response->json() : [];
        $data = collect($response->json());

        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $perPage = 10;
        $currentItems = $data->slice(($currentPage - 1) * $perPage, $perPage)->values();

        $kategoris = new LengthAwarePaginator(
            $currentItems,
            $data->count(),
            $perPage,
            $currentPage,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        $breadcrumb = (object)[
            'title' => 'Data Kategori',
            'list' => ['Kategori']
        ];

        return view('kategori.index', compact('kategoris', 'breadcrumb'))->with('activeMenu', 'kategori');
    }

    public function create()
    {
        $breadcrumb = (object)[
            'title' => 'Tambah Kategori',
            'list' => ['Kategori', 'Tambah']
        ];

        return view('kategori.create', compact('breadcrumb'))->with('activeMenu', 'kategori');
    }

    public function store(Request $request)
    {
        $response = Http::post('http://localhost:8003/api/kategori', [
            'kategori_kode' => $request->kategori_kode,
            'kategori_nama' => $request->kategori_nama
        ]);

        if ($response->successful()) {
            return redirect('/kategori')->with('success', 'Data kategori berhasil ditambahkan');
        }

        return back()->with('error', 'Gagal menambahkan kategori');
    }

    public function show($id)
    {
        $breadcrumb = (object)[
            'title' => 'Detail Kategori',
            'list' => ['Detail Kategori']
        ];

        $res = Http::get("http://localhost:8003/api/kategori/{$id}");

        if (!$res->successful() || empty($res->json())) {
            return redirect('/kategori')->with('error', 'Data kategori tidak ditemukan.');
        }
        

        $kategoris = $res->json();
        return view('kategori.show', compact('kategoris', 'breadcrumb'))->with('activeMenu', 'kategori');
    }

    public function edit($id)
    {
        $kategoris = Http::get("http://localhost:8003/api/kategori/{$id}")->json();

        $breadcrumb = (object)[
            'title' => 'Edit Kategori',
            'list' => ['Kategori', 'Edit']
        ];

        return view('kategori.edit', compact('kategoris', 'breadcrumb'))->with('activeMenu', 'kategori');
    }

    public function update(Request $request, $id)
    {
        $response = Http::put("http://localhost:8003/api/kategori/{$id}", [
            'kategori_kode' => $request->kategori_kode,
            'kategori_nama' => $request->kategori_nama
        ]);

        if ($response->successful()) {
            return redirect('/kategori')->with('success', 'Data kategori berhasil diperbarui');
        }

        return back()->with('error', 'Gagal memperbarui kategori');
    }

    public function destroy($id)
    {
        $response = Http::delete("http://localhost:8003/api/kategori/{$id}");

        if ($response->successful()) {
            return redirect('/kategori')->with('success', 'Data kategori berhasil dihapus');
        }

        return back()->with('error', 'Gagal menghapus kategori');
    }
}
