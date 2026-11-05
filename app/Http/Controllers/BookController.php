<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;

class BookController extends Controller
{
    // 1. Menampilkan daftar buku
    public function index()
    {
        $books = Book::with('category')
            ->latest()
            ->paginate(10);

        return view('books.index', compact('books'));
    }

    // 2. Menampilkan form tambah buku
    public function create()
    {
        $categories = Category::orderBy('name')->get();

        return view('books.create', compact('categories'));
    }

    // 3. Menyimpan buku baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'year' => 'required|integer|min:1000|max:' . date('Y'),
            'stock' => 'required|integer|min:0',
        ]);

        $book = new Book();
        $book->category_id = $validated['category_id'];
        $book->title = $validated['title'];
        $book->author = $validated['author'];
        $book->year = $validated['year'];
        $book->stock = $validated['stock'];
        $book->save();

        return redirect()->route('books.index')
            ->with('success', 'Buku berhasil ditambahkan.');
    }

    // 4. Menampilkan detail buku
    public function show(Book $book)
    {
        $book->load('category');

        return view('books.show', compact('book'));
    }

    // 5. Menampilkan form edit buku
    public function edit(Book $book)
    {
        $categories = Category::orderBy('name')->get();

        return view('books.edit', compact('book', 'categories'));
    }

    // 6. Memperbarui data buku
    public function update(Request $request, Book $book)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'year' => 'required|integer|min:1000|max:' . date('Y'),
            'stock' => 'required|integer|min:0',
        ]);

        $book->category_id = $validated['category_id'];
        $book->title = $validated['title'];
        $book->author = $validated['author'];
        $book->year = $validated['year'];
        $book->stock = $validated['stock'];
        $book->save();

        return redirect()->route('books.index')
            ->with('success', 'Data buku berhasil diperbarui.');
    }

    // 7. Menghapus buku
    public function destroy(Book $book)
    {
        // Mencegah penghapusan buku yang memiliki riwayat peminjaman
        if ($book->borrowingDetails()->exists()) {
            return redirect()->route('books.index')
                ->with('error', 'Buku tidak dapat dihapus karena memiliki riwayat peminjaman.');
        }

        $book->delete();

        return redirect()->route('books.index')
            ->with('success', 'Buku berhasil dihapus.');
    }
}
