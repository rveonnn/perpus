<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Buku;
use App\Models\Peminjaman;

class DashboardController extends Controller
{
    public function stats()
    {
        return response()->json([
            'total_users' => User::count(),
            'total_books' => Buku::count(),
            'active_loans' => Peminjaman::whereNull('tanggal_dikembalikan')->count(),
        ]);
    }
}
