<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil ID masing-masing kategori sesuai nama di CategorySeeder
        $fantasi     = Category::where('name', 'Fantasi')->first();
        $survival    = Category::where('name', 'Survival')->first();
        $sliceOfLife = Category::where('name', 'Slice of Life')->first();
        $romantis    = Category::where('name', 'Romantis')->first();
        $thriller    = Category::where('name', 'Thriller')->first();

        // 1. Kategori Fantasi
        Book::firstOrCreate(
            ['title' => 'Alaia'],
            [
                'category_id' => $fantasi->id,
                'author'      => 'Raden Chedid',
                'year'        => 2024,
                'stock'       => 50,
            ]
        );

        // 2. Kategori Survival
        Book::firstOrCreate(
            ['title' => 'Si Anak Cahaya'],
            [
                'category_id' => $survival->id,
                'author'      => 'Tere Liye',
                'year'        => 2018,
                'stock'       => 5,
            ]
        );

        // 3. Kategori Slice of Life
        Book::firstOrCreate(
            ['title' => 'Filosofi Teras'],
            [
                'category_id' => $sliceOfLife->id,
                'author'      => 'Henry Manampiring',
                'year'        => 2018,
                'stock'       => 15,
            ]
        );

        // 4. Kategori Romantis
        Book::firstOrCreate(
            ['title' => 'Hujan'],
            [
                'category_id' => $romantis->id,
                'author'      => 'Tere Liye',
                'year'        => 2016,
                'stock'       => 20,
            ]
        );

        // 5. Kategori Thriller
        Book::firstOrCreate(
            ['title' => 'Negeri Para Bedebah'],
            [
                'category_id' => $thriller->id,
                'author'      => 'Tere Liye',
                'year'        => 2012,
                'stock'       => 15,
            ]
        );
    }
}