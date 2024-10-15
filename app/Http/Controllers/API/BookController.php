<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Author;
use Illuminate\Http\Response;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
      $books = Book::with('author')->get();
      return response()->json($books, Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
          'title'        => 'required|string|max:255',
          'description'  => 'nullable|string',
          'publish_date' => 'nullable|date',
          'author_id'    => 'required|exists:authors,id',
      ]);

      $book = Book::create($validated);

      return response()->json($book, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $book = Book::with('author')->find($id);

        if (!$book) {
            return response()->json(['message' => 'Book not found'], Response::HTTP_NOT_FOUND);
        }

        return response()->json($book, Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $book = Book::find($id);

        if (!$book) {
            return response()->json(['message' => 'Book not found'], Response::HTTP_NOT_FOUND);
        }

        $validated = $request->validate([
            'title'        => 'sometimes|required|string|max:255',
            'description'  => 'nullable|string',
            'publish_date' => 'nullable|date',
            'author_id'    => 'sometimes|required|exists:authors,id',
        ]);

        $book->update($validated);

        return response()->json($book, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $book = Book::find($id);

        if (!$book) {
            return response()->json(['message' => 'Book not found'], Response::HTTP_NOT_FOUND);
        }

        $book->delete();

        return response()->json(['message' => 'Book deleted successfully'], Response::HTTP_OK);
    }
}
