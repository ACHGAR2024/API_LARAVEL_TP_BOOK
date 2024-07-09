<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index()
    {
        return Book::with('author', 'genres')->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'summary' => 'nullable|string',
            'author_id' => 'required|exists:authors,id',
            'genres' => 'array',
            'genres.*' => 'exists:genres,id',
        ]);

        $book = Book::create($request->only('title', 'summary', 'author_id'));

        if ($request->has('genres')) {
            $book->genres()->sync($request->genres);
        }

        return $book->load('author', 'genres');
    }

    public function show($id)
    {
        return Book::with('author', 'genres')->findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $book = Book::findOrFail($id);
        $request->validate([
            'title' => 'required|string|max:255',
            'summary' => 'nullable|string',
            'author_id' => 'required|exists:authors,id',
            'genres' => 'array',
            'genres.*' => 'exists:genres,id',
        ]);

        $book->update($request->only('title', 'summary', 'author_id'));

        if ($request->has('genres')) {
            $book->genres()->sync($request->genres);
        }

        return $book->load('author', 'genres');
    }

    public function destroy($id)
    {
        Book::findOrFail($id)->delete();
        return response()->noContent();
    }
}