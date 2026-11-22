<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        Category::firstOrCreate(
            ['name' => 'Fantasi'],
            ['description' => 'Buku seputar imajinasi']
        );

        Category::firstOrCreate(
            ['name' => 'Survival'],
            ['description' => 'Buku seputar bagaimana seseorang bertahan hidup']
        );

        Category::firstOrCreate(
            ['name' => 'Slice of Life'],
            ['description' => 'Buku seputar perjalanan hidup']
        );

        Category::firstOrCreate(
            ['name' => 'Romantis'],
            ['description' => 'Buku seputar kisah cinta']
        );

        Category::firstOrCreate(
            ['name' => 'Thriller'],
            ['description' => 'Buku seputar perjalanan yang menegangkan dan penuh misteri']
        );
    }
}