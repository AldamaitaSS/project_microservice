<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BukuModel;
use Yajra\DataTables\Facades\DataTables;

class BukuController extends Controller
{
   public function index()
    {
        $bukus = BukuModel::with('kategori')->get();

        $bukus = $bukus->map(function ($buku) {
            return [
                'buku_id' => $buku->buku_id,
                'judul' => $buku->judul,
                'penulis' => $buku->penulis,
                'stok' => $buku->stok,
                'kategori_id' => $buku->kategori_id,
                'kategori_nama' => $buku->kategori->kategori_nama ?? null,
            ];
        });
        return response()->json(BukuModel::all());
    }

    public function show($id)
    {
        $buku = BukuModel::with('kategori')->find($id);
        if (!$buku) {
            return response()->json(null, 404);
        }
        return response()->json([
            'buku_id' => $buku->buku_id,
            'judul' => $buku->judul,
            'penulis' => $buku->penulis,
            'stok' => $buku->stok,
            'kategori_id' => $buku->kategori_id,
            'kategori_nama' => $buku->kategori->kategori_nama ?? null,
        ]);

        return response()->json($buku);
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string',
            'penulis' => 'required|string',
            'stok' => 'required|integer|min:0',
            'kategori_id' => 'required|integer|exists:m_kategori,kategori_id',
        ]);

        $buku = BukuModel::create($validated);
        return response()->json([
            'message' => 'Buku berhasil ditambahkan',
            'data' => $buku->load('kategori') // kalau ingin sekalian tampilkan kategori-nya
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'judul' => 'sometimes|string',
            'penulis' => 'sometimes|string',
            'stok' => 'sometimes|integer|min:0',
            'kategori_id' => 'required|integer|exists:m_kategori,kategori_id',
        ]);
        
        $buku = BukuModel::with('kategori')->findOrFail($id);
        $buku->update($validated);
        return response()->json($buku);
    }

    public function destroy($id)
    {
        $buku = BukuModel::findOrFail($id);
        $buku->delete();
        return response()->json(null, 204);
    }

    public function search(Request $request)
    {
        $search = $request->query('search');

        $query = BukuModel::query();

        if ($search) {
            $query->whereRaw('LOWER(judul) LIKE ?', ['%' . strtolower($search) . '%']);
        }

        $result = $query->get(['buku_id', 'judul', 'stok']);

        return response()->json($result);
    }

    public function kurangiStok($id)
    {
        $buku = BukuModel::find($id);

        if (!$buku || $buku->stok < 1) {
            return response()->json(['message' => 'Stok tidak cukup atau buku tidak ditemukan'], 400);
        }

        $buku->stok -= 1;
        $buku->save();

        return response()->json([
            'message' => 'Stok berhasil dikurangi',
            'stok_sekarang' => $buku->stok
        ]);
    }

    public function tambahStok($id)
    {
        $buku = BukuModel::find($id);

        if (!$buku) {
            return response()->json(['message' => 'Buku tidak ditemukan'], 404);
        }

        $buku->stok += 1;
        $buku->save();

        return response()->json([
            'message' => 'Stok berhasil dikembalikan',
            'stok_sekarang' => $buku->stok
        ]);
    }

}
