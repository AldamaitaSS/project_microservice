<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class RiwayatController extends Controller
{
    public function index(Request $request)
    {
        $user_id = session('user_id');
    
        $response = Http::get("http://localhost:8003/api/riwayat/{$user_id}");

        $data = collect($response->json());

        // Pagination
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $perPage = 10;
        $currentItems = $data->slice(($currentPage - 1) * $perPage, $perPage)->values();

        $riwayat = new LengthAwarePaginator(
            $currentItems,
            $data->count(),
            $perPage,
            $currentPage,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        $breadcrumb = (object)[
            'title' => 'Riwayat Peminjaman',
            'list' => ['Riwayat Peminjaman']
        ];

        return view('riwayat.index', compact('riwayat', 'breadcrumb'))->with('activeMenu', 'riwayat');
    }

}
