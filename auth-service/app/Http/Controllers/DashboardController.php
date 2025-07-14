<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserModel;

class DashboardController extends Controller
{
    public function index()
    {
        $recentUsers = UserModel::orderBy('user_id', 'desc')->take(5)->get();

        return response()->json([
            'recent_users' => $recentUsers
        ]);

    }
}
