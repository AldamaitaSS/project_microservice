<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DashboardController extends Controller
{
    public function index()
    {
        $level = session('level_id');
        $user_id = session('user_id');
        $token = session('token');

        // if ($level == 1) {
            // $dashboardData = Http::withToken($token)->get('http://localhost:8003/api/dashboard-admin')->json();
            // dd($dashboardData);

            if ($level == 1) {

                $breadcrumb = (object)[
                     'title' => 'Dashboard',
                    'list' => ['Dashboard']
                ];

                $dashboardData = Http::withToken($token)->get('http://localhost:8003/api/dashboard-admin')->json();

                return view('dashboard_admin', [
                    'recentUsers' => $dashboardData['recent_users'] ?? [],
                    'recentPinjam' => $dashboardData['recent_pinjam'] ?? [],
                    'breadcrumb' => $breadcrumb,
                    'activeMenu' => 'dashboard'
                ]);
            }

        // }

        if ($level == 2) {
            Http::get('http://localhost:8003/api/pinjam/cek-kembali-otomatis');
            $breadcrumb = (object)[
                'title' => 'Pencarian Buku',
                'list' => ['Pencarian Buku']
            ];

            $pinjam = Http::withToken($token)->get("http://localhost:8003/api/dashboard-user/{$user_id}")->json();
            $search = request()->query('q');
            $buku = [];

            if ($search) {
                $buku = Http::withToken($token)->get("http://localhost:8003/api/buku/search?q={$search}")->json();
            }
            
            return view('dashboard_user', [
                'pinjam' => $pinjam,
                'buku' => $buku,
                'breadcrumb' => $breadcrumb,
                'activeMenu' => 'dashboard'
            ]);
        }

        $breadcrumb = (object)[
            'title' => 'Dashboard',
            'list' => ['Dashboard']
        ];

        return view('dashboard', [
            'breadcrumb' => $breadcrumb,
            'activeMenu' => 'dashboard'
        ]);

    }
}
