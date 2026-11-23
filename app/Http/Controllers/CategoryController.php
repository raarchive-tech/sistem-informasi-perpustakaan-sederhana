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
        $categories = Category::oldest()->paginate(10);

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
            'name'        => ['required', 'string', 'max:255', 'unique:categories,name', 'regex:/^[a-zA-Z\s\-\.,()]+$/'],
            'description' => ['nullable', 'string', 'regex:/^[a-zA-Z\s\-\.,()]+$/'],
        ], [
            'name.unique'       => 'Nama kategori sudah ada, silakan gunakan nama lain.',
            'name.regex'        => 'Nama kategori hanya boleh berisi huruf dan spasi (tidak boleh angka).',
            'description.regex' => 'Deskripsi kategori hanya boleh berisi huruf (tidak boleh angka).',
        ]);

        $category = new Category();
        $category->name = $validated['name'];
        $category->description = $validated['description'] ?? null;
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
            'name'        => ['required', 'string', 'max:255', 'unique:categories,name,' . $category->id, 'regex:/^[a-zA-Z\s\-\.,()]+$/'],
            'description' => ['nullable', 'string', 'regex:/^[a-zA-Z\s\-\.,()]+$/'],
        ], [
            'name.unique'       => 'Nama kategori sudah digunakan oleh kategori lain.',
            'name.regex'        => 'Nama kategori hanya boleh berisi huruf dan spasi (tidak boleh angka).',
            'description.regex' => 'Deskripsi kategori hanya boleh berisi huruf (tidak boleh angka).',
        ]);

        $category->name = $validated['name'];
        $category->description = $validated['description'] ?? null;
        $category->save();

        return redirect()->route('categories.index')
            ->with('success', 'Data kategori berhasil diperbarui.');
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
