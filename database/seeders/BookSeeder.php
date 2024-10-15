<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Book;
use App\Models\Author;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
      // Pastikan ada Authors sebelum membuat Books
      $authors = Author::all();

      // Jika tidak ada Authors, buat beberapa
      if ($authors->isEmpty()) {
          $authors = Author::factory(10)->create();
      }

      // Untuk setiap Author, buat 5 Books
      foreach ($authors as $author) {
          Book::factory(5)->create([
              'author_id' => $author->id,
          ]);
      }
    }
}
