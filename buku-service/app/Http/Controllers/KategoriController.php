<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KategoriModel;

class KategoriController extends Controller
{
    public function index()
    {
        return response()->json(KategoriModel::all());
    }
    public function show($id)
    {
        $kategori = KategoriModel::find($id);
        if (!$kategori) {
            return response()->json(null, 404);
        }

        return response()->json($kategori);
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kategori_kode' => 'required|string',
            'kategori_nama' => 'required|string'
        ]);

        $kategori = KategoriModel::create($validated);
        return response()->json($kategori, 201);
    }
    public function update(Request $request, $id)
    {
        $kategori = KategoriModel::findOrFail($id);
        $kategori->update($request->all());

        return response()->json($kategori);
    }

    public function destroy($id)
    {
        $kategori = KategoriModel::findOrFail($id);
        $kategori->delete();
        return response()->json(null, 204);
    }

}
