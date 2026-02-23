<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::insert([
            ['nama_kategori' => 'Celana'],
            ['nama_kategori' => 'Baju'],
            ['nama_kategori' => 'Jaket'],
        ]);
    }
}