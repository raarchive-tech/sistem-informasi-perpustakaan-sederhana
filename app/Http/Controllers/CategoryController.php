<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Book;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // 1. Menampilkan daftar kategori
    public function index()
    {
        $categories = Category::latest()->paginate(10);

        return view('categories.index', compact('categories'));
    }

    // 2. Menampilkan form tambah kategori
    public function create()
    {
        return view('categories.create');
    }

    // 3. Menyimpan kategori baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'decsription' => 'nullable|string',
        ]);

        $category = new Category();
        $category->name = $validated['name'];
        $category->decsription = $validated['decsription'] ?? null;
        $category->save();

        return redirect()->route('categories.index')
            ->with('success', 'Kategori berhasil ditambahkan.');
    }

    // 4. Menampilkan detail kategori
    public function show(Category $category)
    {
        return view('categories.show', compact('category'));
    }

    // 5. Menampilkan form edit kategori
    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    // 6. Memperbarui kategori
    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            'decsription' => 'nullable|string',
        ]);

        $category->name = $validated['name'];
        $category->decsription = $validated['decsription'] ?? null;
        $category->save();

        return redirect()->route('categories.index')
            ->with('success', 'Kategori berhasil diperbarui.');
    }

    // 7. Menghapus kategori
    public function destroy(Category $category)
    {
        // Mencegah penghapusan kategori yang masih digunakan buku
        if (Book::where('category_id', $category->id)->exists()) {
            return redirect()->route('categories.index')
                ->with('error', 'Kategori tidak dapat dihapus karena masih digunakan oleh buku.');
        }

        $category->delete();

        return redirect()->route('categories.index')
            ->with('success', 'Kategori berhasil dihapus.');
    }
}
