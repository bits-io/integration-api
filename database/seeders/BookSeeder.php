<?php

namespace Database\Seeders;

use App\Models\Book;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Book::create([
            'title' => 'Laravel for Beginners',
            'author' => 'John Doe',
            'year' => 2023,
            'description' => 'Introduction to Laravel framework.',
        ]);
    }
}
