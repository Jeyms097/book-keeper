<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Author;


class AuthorController extends Controller
{
    public function index()
    {
        $authors = Author::with('books')->latest()->get();
        return view('authors.index', compact('authors'));
    }

    public function create()
    {
        return view('authors.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:authors,name',
            'birth_date' => 'required|date|before_or_equal:today',
        ]);

        $author = Author::create($validated);
        if ($request->ajax()) {
            return response()->json(['message' => 'Author created successfully!', 'data' => $author]);
        }
        return redirect()->route('authors.index')->with('success', 'Author created successfully');
    }

    public function show(Author $author)
    {
        return view('authors.show', compact('author'));
    }

    public function edit(Author $author)
    {
        return view('authors.edit', compact('author'));
    }

    public function update(Request $request, Author $author)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:authors,name,' . $author->id,
            'birth_date' => 'required|date|before_or_equal:today',
        ]);

        $author->update($validated);

        if ($request->ajax()) {
            return response()->json([
                'message' => 'Author updated successfully!',
                'data' => $author,
            ]);
        }

        return redirect()->route('authors.index')->with('success', 'Author updated successfully!');
    }


    public function destroy(Author $author)
    {
        $author->delete();
        return redirect()->route('authors.index')->with('success', 'Author deleted successfully!');
    }
}
