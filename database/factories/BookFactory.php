<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Book;
use App\Models\Author;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Book::class;

    public function definition(): array
    {
        return [
          'title'        => $this->faker->sentence(6, true),
          'description'  => $this->faker->paragraph(3, true),
          'publish_date' => $this->faker->date(),
          'author_id'    => Author::factory(), // Membuat Author baru jika belum ada
      ];
    }
}
