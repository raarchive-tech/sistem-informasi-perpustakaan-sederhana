<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Member;
use App\Models\Borrowing;

class DashboardController extends Controller
{
    // Menampilkan dashboard
    public function index()
    {
        // Menghitung jumlah judul buku
        $totalBooks = Book::count();

        // Menghitung total stok buku
        $totalStock = Book::sum('stock');

        // Menghitung jumlah anggota
        $totalMembers = Member::count();

        // Menghitung peminjaman yang belum dikembalikan
        $totalBorrowed = Borrowing::where('status', 'borrowed')->count();

        return view('dashboard', compact(
            'totalBooks',
            'totalStock',
            'totalMembers',
            'totalBorrowed'
        ));
    }
}
