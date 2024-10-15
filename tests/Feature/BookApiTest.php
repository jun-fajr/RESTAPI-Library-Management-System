<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Book;
use App\Models\Author;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Carbon\Carbon;

class BookApiTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test listing all books.
     *
     * @return void
     */
    public function test_can_list_books()
    {
        // Membuat 5 books menggunakan factory
        Book::factory()->count(5)->create();

        // Mengirim GET request ke endpoint /api/books
        $response = $this->getJson('/api/books');

        // Memastikan respons status 200 OK
        $response->assertStatus(200);

        // Memastikan bahwa ada 5 data dalam respons
        $response->assertJsonCount(5);
    }

    /**
     * Test creating a new book.
     *
     * @return void
     */
    public function test_can_create_book()
    {
      $publish_date = Carbon::parse('2023-01-01')->toDateTimeString(); // '2023-01-01 00:00:00'

        // Membuat author terlebih dahulu
        $author = Author::factory()->create();

        // Data yang akan dikirimkan dalam request
        $data = [
            'title' => 'Laravel Testing',
            'description' => 'A comprehensive guide to testing in Laravel.',
            'publish_date' => '2023-01-01',
            'author_id' => $author->id,
        ];

        // Mengirim POST request ke endpoint /api/books
        $response = $this->postJson('/api/books', $data);

        // Memastikan respons status 201 Created
        $response->assertStatus(201);

        // Memastikan bahwa data tersimpan di database
        $this->assertDatabaseHas('books', [
            'title' => 'Laravel Testing',
            'description' => 'A comprehensive guide to testing in Laravel.',
            'publish_date' => $publish_date,
            'author_id' => $author->id,
        ]);

        // Memastikan struktur respons
        $response->assertJsonStructure([
            'id',
            'title',
            'description',
            'publish_date',
            'author_id',
            'created_at',
            'updated_at',
        ]);
    }

    /**
     * Test viewing a single book.
     *
     * @return void
     */
    public function test_can_view_book()
    {
        // Membuat book menggunakan factory
        $book = Book::factory()->create();

        // Mengirim GET request ke endpoint /api/books/{id}
        $response = $this->getJson("/api/books/{$book->id}");

        // Memastikan respons status 200 OK
        $response->assertStatus(200);

        // Memastikan bahwa data yang dikembalikan sesuai
        $response->assertJson([
            'id' => $book->id,
            'title' => $book->title,
            'description' => $book->description,
            // 'publish_date' => $book->publish_date->toDateString(),
            'publish_date' => $book->publish_date->format('Y-m-d\TH:i:s.u\Z'),
            'author_id' => $book->author_id,
        ]);
    }

    /**
     * Test updating an existing book.
     *
     * @return void
     */
    public function test_can_update_book()
    {
        // Membuat book menggunakan factory
        $book = Book::factory()->create();

        // Membuat author baru untuk memperbarui author_id
        $newAuthor = Author::factory()->create();

        // Data yang akan diperbarui
        $data = [
            'title' => 'Updated Book Title',
            'description' => 'An updated description.',
            'author_id' => $newAuthor->id,
        ];

        // Mengirim PUT request ke endpoint /api/books/{id}
        $response = $this->putJson("/api/books/{$book->id}", $data);

        // Memastikan respons status 200 OK
        $response->assertStatus(200);

        // Memastikan bahwa data di database telah diperbarui
        $this->assertDatabaseHas('books', [
            'id' => $book->id,
            'title' => 'Updated Book Title',
            'description' => 'An updated description.',
            'author_id' => $newAuthor->id,
        ]);

        // Memastikan struktur respons
        $response->assertJson([
            'id' => $book->id,
            'title' => 'Updated Book Title',
            'description' => 'An updated description.',
            // 'publish_date' => $book->publish_date->toDateString(),
            'publish_date' => $book->publish_date->format('Y-m-d\TH:i:s.u\Z'),
            'author_id' => $newAuthor->id,
        ]);
    }

    /**
     * Test deleting a book.
     *
     * @return void
     */
    public function test_can_delete_book()
    {
        // Membuat book menggunakan factory
        $book = Book::factory()->create();

        // Mengirim DELETE request ke endpoint /api/books/{id}
        $response = $this->deleteJson("/api/books/{$book->id}");

        // Memastikan respons status 200 OK
        $response->assertStatus(200);

        // Memastikan bahwa book telah dihapus dari database
        $this->assertDatabaseMissing('books', [
            'id' => $book->id,
        ]);

        // Memastikan respons mengandung pesan sukses
        $response->assertJson([
            'message' => 'Book deleted successfully',
        ]);
    }

    /**
     * Test validation when creating a book.
     *
     * @return void
     */
    public function test_validation_on_create_book()
    {
        // Data invalid (title kosong, author_id tidak ada)
        $data = [
            'title' => '',
            'description' => 'Description without a title.',
            'publish_date' => 'invalid-date',
            'author_id' => 999, // Asumsikan tidak ada author dengan id ini
        ];

        // Mengirim POST request ke endpoint /api/books
        $response = $this->postJson('/api/books', $data);

        // Memastikan respons status 422 Unprocessable Entity
        $response->assertStatus(422);

        // Memastikan bahwa terdapat kesalahan validasi
        $response->assertJsonValidationErrors(['title', 'publish_date', 'author_id']);
    }

    /**
     * Test viewing a non-existent book.
     *
     * @return void
     */
    public function test_view_non_existent_book()
    {
        // Mengirim GET request ke endpoint /api/books/{id} dengan id yang tidak ada
        $response = $this->getJson('/api/books/999');

        // Memastikan respons status 404 Not Found
        $response->assertStatus(404);

        // Memastikan pesan error
        $response->assertJson([
            'message' => 'Book not found',
        ]);
    }
}
