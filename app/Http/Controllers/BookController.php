<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    // 1. Menampilkan daftar buku
    public function index(Request $request)
    {
        $search = $request->input('search');

        $books = Book::with('category')
            ->when($search, function ($query, $search) {
                $query->where('title', 'like', "%{$search}%")
                      ->orWhere('author', 'like', "%{$search}%")
                      ->orWhereHas('category', function ($q) use ($search) {
                          $q->where('name', 'like', "%{$search}%");
                      });
            })
            ->oldest()
            ->paginate(10)
            ->withQueryString();

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
            'title'       => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z\s\-\.,:;!?\'"]+$/'],
            'author'      => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z\s\.\',\-]+$/'],
            'year'        => 'required|integer|min:1900|max:2026',
            'stock'       => 'required|integer|min:1',
            'cover'       => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ], [
            'title.regex'  => 'Judul buku hanya boleh berisi huruf (tidak boleh angka).',
            'author.regex' => 'Nama penulis hanya boleh berisi huruf (tidak boleh angka).',
            'year.min'     => 'Tahun terbit minimal tahun 1900.',
            'year.max'     => 'Tahun terbit maksimal tahun 2026.',
            'stock.min'    => 'Jumlah stok minimal adalah 1.',
            'cover.image'  => 'File cover harus berupa gambar.',
            'cover.mimes'  => 'Format cover harus jpeg, png, jpg, atau webp.',
            'cover.max'    => 'Ukuran gambar cover maksimal 2MB.',
        ]);

        $book = new Book();
        $book->category_id = $validated['category_id'];
        $book->title = $validated['title'];
        $book->author = $validated['author'];
        $book->year = $validated['year'];
        $book->stock = $validated['stock'];

        if ($request->hasFile('cover')) {
            $book->cover = $request->file('cover')->store('covers', 'public');
        }

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
            'title'       => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z\s\-\.,:;!?\'"]+$/'],
            'author'      => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z\s\.\',\-]+$/'],
            'year'        => 'required|integer|min:1900|max:2026',
            'stock'       => 'required|integer|min:1',
            'cover'       => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ], [
            'title.regex'  => 'Judul buku hanya boleh berisi huruf (tidak boleh angka).',
            'author.regex' => 'Nama penulis hanya boleh berisi huruf (tidak boleh angka).',
            'year.min'     => 'Tahun terbit minimal tahun 1900.',
            'year.max'     => 'Tahun terbit maksimal tahun 2026.',
            'stock.min'    => 'Jumlah stok minimal adalah 1.',
            'cover.image'  => 'File cover harus berupa gambar.',
            'cover.mimes'  => 'Format cover harus jpeg, png, jpg, atau webp.',
            'cover.max'    => 'Ukuran gambar cover maksimal 2MB.',
        ]);

        $book->category_id = $validated['category_id'];
        $book->title = $validated['title'];
        $book->author = $validated['author'];
        $book->year = $validated['year'];
        $book->stock = $validated['stock'];

        if ($request->hasFile('cover')) {
            if ($book->cover && Storage::disk('public')->exists($book->cover)) {
                Storage::disk('public')->delete($book->cover);
            }
            $book->cover = $request->file('cover')->store('covers', 'public');
        }

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

        if ($book->cover && Storage::disk('public')->exists($book->cover)) {
            Storage::disk('public')->delete($book->cover);
        }

        $book->delete();

        return redirect()->route('books.index')
            ->with('success', 'Buku berhasil dihapus.');
    }
}