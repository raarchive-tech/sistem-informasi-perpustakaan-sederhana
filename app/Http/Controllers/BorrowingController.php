<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrowing;
use App\Models\BorrowingDetail;
use App\Models\Member;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BorrowingController extends Controller
{
    // Menampilkan daftar peminjaman
    public function index(Request $request)
    {
        $search = $request->input('search');

        $borrowings = Borrowing::with(['member', 'user'])
            ->when($search, function ($query, $search) {
                $query->where('status', 'like', "%{$search}%")
                    ->orWhereHas('member', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%")
                            ->orWhere('member_code', 'like', "%{$search}%");
                    })
                    ->orWhereHas('user', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    });
            })
            ->oldest()
            ->paginate(10)
            ->withQueryString();

        return view('borrowings.index', compact('borrowings'));
    }

    // Menampilkan form peminjaman
    public function create()
    {
        $members = Member::orderBy('name')->get();
        $books = Book::where('stock', '>', 0)->orderBy('title')->get();

        return view('borrowings.create', compact('members', 'books'));
    }

    // Menyimpan transaksi peminjaman
    public function store(Request $request)
    {
        $validated = $request->validate([
            'member_id'          => 'required|exists:members,id',
            'borrow_date'        => 'required|date|date_equals:today',
            'details'            => 'required|array|min:1',
            'details.*.book_id'  => 'required|distinct|exists:books,id',
            'details.*.quantity' => 'required|integer|min:1',
        ], [
            'member_id.required'           => 'Anggota wajib dipilih.',
            'borrow_date.date_equals'      => 'Tanggal peminjaman harus sesuai dengan tanggal hari ini.',
            'details.*.book_id.required'   => 'Buku wajib dipilih.',
            'details.*.book_id.distinct'   => 'Jangan memilih judul buku yang sama di dua baris berbeda.',
            'details.*.quantity.min'       => 'Jumlah pinjam minimal adalah 1.',
        ]);

        DB::transaction(function () use ($validated) {
            $today = now()->toDateString();

            // Membuat transaksi peminjaman
            $borrowing = Borrowing::create([
                'member_id'   => $validated['member_id'],
                'user_id'     => auth()->id(),
                'borrow_date' => $today,
                'due_date'    => Carbon::parse($today)->addDays(7)->toDateString(),
                'return_date' => null,
                'status'      => 'borrowed',
            ]);

            // Menyimpan detail dan mengurangi stok buku
            foreach ($validated['details'] as $detail) {

                $book = Book::where('id', $detail['book_id'])
                    ->lockForUpdate()
                    ->firstOrFail();

                if ($book->stock < $detail['quantity']) {
                    throw \Illuminate\Validation\ValidationException::withMessages([
                        'details' => 'Stok buku ' . $book->title . ' tidak mencukupi.',
                    ]);
                }

                BorrowingDetail::create([
                    'borrowing_id' => $borrowing->id,
                    'book_id'      => $book->id,
                    'quantity'     => $detail['quantity'],
                ]);

                $book->decrement('stock', $detail['quantity']);
            }
        });

        return redirect()->route('borrowings.index')
            ->with('success', 'Peminjaman berhasil ditambahkan.');
    }

    // Menampilkan detail peminjaman
    public function show(Borrowing $borrowing)
    {
        $borrowing->load(['member', 'user', 'details.book']);

        return view('borrowings.show', compact('borrowing'));
    }

    // Memproses pengembalian buku
    public function returnBook(Borrowing $borrowing)
    {
        DB::transaction(function () use ($borrowing) {

            $borrowing = Borrowing::where('id', $borrowing->id)
                ->lockForUpdate()
                ->firstOrFail();

            if ($borrowing->status === 'returned') {
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'borrowing' => 'Buku sudah dikembalikan.',
                ]);
            }

            $details = BorrowingDetail::where(
                'borrowing_id',
                $borrowing->id
            )->get();

            foreach ($details as $detail) {
                $book = Book::where('id', $detail->book_id)
                    ->lockForUpdate()
                    ->firstOrFail();

                $book->increment('stock', $detail->quantity);
            }

            $borrowing->update([
                'return_date' => now()->toDateString(),
                'status'      => 'returned',
            ]);
        });

        return redirect()->route('borrowings.index')
            ->with('success', 'Buku berhasil dikembalikan.');
    }
}