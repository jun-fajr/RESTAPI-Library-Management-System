<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Author;
use Illuminate\Http\Response;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
      $authors = Author::with('books')->get();
      return response()->json($authors, Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
          'name'       => 'required|string|max:255',
          'bio'        => 'nullable|string',
          'birth_date' => 'nullable|date',
      ]);

      $author = Author::create($validated);

      return response()->json($author, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $author = Author::with('books')->find($id);

        if (!$author) {
            return response()->json(['message' => 'Author not found'], Response::HTTP_NOT_FOUND);
        }

        return response()->json($author, Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $author = Author::find($id);

        if (!$author) {
            return response()->json(['message' => 'Author not found'], Response::HTTP_NOT_FOUND);
        }

        $validated = $request->validate([
            'name'       => 'sometimes|required|string|max:255',
            'bio'        => 'nullable|string',
            'birth_date' => 'nullable|date',
        ]);

        $author->update($validated);

        return response()->json($author, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
      {
        $author = Author::find($id);

        if (!$author) {
            return response()->json(['message' => 'Author not found'], Response::HTTP_NOT_FOUND);
        }

        $author->delete();

        return response()->json(['message' => 'Author deleted successfully'], Response::HTTP_OK);
    }
}
