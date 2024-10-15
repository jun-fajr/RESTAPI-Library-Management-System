<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Author;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Carbon\Carbon;

class AuthorApiTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test listing all authors.
     *
     * @return void
     */
    public function test_can_list_authors()
    {

        // Membuat 3 authors menggunakan factory
        Author::factory()->count(3)->create();

        // Mengirim GET request ke endpoint /api/authors
        $response = $this->getJson('/api/authors');

        // Memastikan respons status 200 OK
        $response->assertStatus(200);

        // Memastikan bahwa ada 3 data dalam respons
        $response->assertJsonCount(3);
    }

    /**
     * Test creating a new author.
     *
     * @return void
     */
    public function test_can_create_author()
    {
      // $birthDate = Carbon::parse('1980-05-15')->toDateString(); // '1980-05-15'
      $birthDate = Carbon::parse('1980-05-15')->toDateTimeString(); // '1980-05-15 00:00:00'


        // Data yang akan dikirimkan dalam request
        $data = [
            'name' => 'John Doe',
            'bio' => 'An accomplished writer.',
            'birth_date' => '1980-05-15',
        ];

        // Mengirim POST request ke endpoint /api/authors
        $response = $this->postJson('/api/authors', $data);

        // Memastikan respons status 201 Created
        $response->assertStatus(201);

        // Memastikan bahwa data tersimpan di database
        $this->assertDatabaseHas('authors', [
            'name' => 'John Doe',
            'bio' => 'An accomplished writer.',
            'birth_date' => $birthDate,
        ]);

        // Memastikan struktur respons
        $response->assertJsonStructure([
            'id',
            'name',
            'bio',
            'birth_date',
            'created_at',
            'updated_at',
        ]);
    }

    /**
     * Test viewing a single author.
     *
     * @return void
     */
    public function test_can_view_author()
    {
        // Membuat author menggunakan factory
        $author = Author::factory()->create();

        // Mengirim GET request ke endpoint /api/authors/{id}
        $response = $this->getJson("/api/authors/{$author->id}");

        // Memastikan respons status 200 OK
        $response->assertStatus(200);

        // Memastikan bahwa data yang dikembalikan sesuai
        $response->assertJson([
            'id' => $author->id,
            'name' => $author->name,
            'bio' => $author->bio,
            // 'birth_date' => $author->birth_date->toDateString(),
            'birth_date' => $author->birth_date->format('Y-m-d\TH:i:s.u\Z'),

        ]);
    }

    /**
     * Test updating an existing author.
     *
     * @return void
     */
    public function test_can_update_author()
    {
        // Membuat author menggunakan factory
        $author = Author::factory()->create();

        // Data yang akan diperbarui
        $data = [
            'name' => 'Jane Smith',
            'bio' => 'An updated bio.',
        ];

        // Mengirim PUT request ke endpoint /api/authors/{id}
        $response = $this->putJson("/api/authors/{$author->id}", $data);

        // Memastikan respons status 200 OK
        $response->assertStatus(200);

        // Memastikan bahwa data di database telah diperbarui
        $this->assertDatabaseHas('authors', [
            'id' => $author->id,
            'name' => 'Jane Smith',
            'bio' => 'An updated bio.',
        ]);

        // Memastikan struktur respons
        $response->assertJson([
            'id' => $author->id,
            'name' => 'Jane Smith',
            'bio' => 'An updated bio.',
            // 'birth_date' => $author->birth_date->toDateString(),
            'birth_date' => $author->birth_date->format('Y-m-d\TH:i:s.u\Z'),

        ]);
    }

    /**
     * Test deleting an author.
     *
     * @return void
     */
    public function test_can_delete_author()
    {
        // Membuat author menggunakan factory
        $author = Author::factory()->create();

        // Mengirim DELETE request ke endpoint /api/authors/{id}
        $response = $this->deleteJson("/api/authors/{$author->id}");

        // Memastikan respons status 200 OK
        $response->assertStatus(200);

        // Memastikan bahwa author telah dihapus dari database
        $this->assertDatabaseMissing('authors', [
            'id' => $author->id,
        ]);

        // Memastikan respons mengandung pesan sukses
        $response->assertJson([
            'message' => 'Author deleted successfully',
        ]);
    }

    /**
     * Test validation when creating an author.
     *
     * @return void
     */
    public function test_validation_on_create_author()
    {
        // Data invalid (name kosong)
        $data = [
            'name' => '',
            'bio' => 'Bio without a name.',
            'birth_date' => 'invalid-date',
        ];

        // Mengirim POST request ke endpoint /api/authors
        $response = $this->postJson('/api/authors', $data);

        // Memastikan respons status 422 Unprocessable Entity
        $response->assertStatus(422);

        // Memastikan bahwa terdapat kesalahan validasi
        $response->assertJsonValidationErrors(['name', 'birth_date']);
    }

    /**
     * Test viewing a non-existent author.
     *
     * @return void
     */
    public function test_view_non_existent_author()
    {
        // Mengirim GET request ke endpoint /api/authors/{id} dengan id yang tidak ada
        $response = $this->getJson('/api/authors/999');

        // Memastikan respons status 404 Not Found
        $response->assertStatus(404);

        // Memastikan pesan error
        $response->assertJson([
            'message' => 'Author not found',
        ]);
    }
}
