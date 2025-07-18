<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Author;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::with('author')->latest()->get();
        $authors = \App\Models\Author::all();
        return view('books.index', compact('books', 'authors'));
    }

    public function create()
    {
        $authors = Author::all();
        return view('books.create', compact('authors'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255|unique:books,title',
            'author_id' => 'required|exists:authors,id',
            'published_date' => 'required|date|before_or_equal:today',
        ]);

        $book = Book::create($validated);
        if ($request->ajax()) {
            return response()->json(['message' => 'Book created successfully!', 'data' => $book]);
        }
        return redirect()->route('books.index')->with('success', 'Book created successfully!');
    }

    public function show(Book $book)
    {
        return view('books.show', compact('book'));
    }

    public function edit(Book $book)
    {
        $authors = Author::all();
        return view('books.edit', compact('book', 'authors'));
    }

    public function update(Request $request, Book $book)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255|unique:books,title,' . $book->id,
            'author_id' => 'required|exists:authors,id',
            'published_date' => 'required|date|before_or_equal:today',
        ]);

        $book->update($validated);

        if ($request->ajax()) {
            return response()->json([
                'message' => 'Book updated successfully!',
                'data' => $book,
            ]);
        }

        return redirect()->route('books.index')->with('success', 'Book updated successfully!');
    }

    public function destroy(Book $book)
    {
        $book->delete();
        return redirect()->route('books.index')->with('success', 'Book deleted successfully!');
    }
}
