<?php

namespace App\Http\Controllers;

use App\Http\Middleware\AuthCheck;
use App\Models\Authors;
use App\Models\Books;
use App\Models\Genres;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class BooksController extends Controller
{
    public function __construct()
    {
        return $this->middleware(AuthCheck::class);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $books = Books::orderBy('book_name')->get();
        return view('books.index', ['books' => $books]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $authors = Authors::orderBy('name')->get();
        $genres = Genres::orderBy('name')->get();

        return view('books.create', [
            'authors' => $authors,
            'genres' => $genres,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'published_year' => 'required|integer|min:1000|max:' . date('Y'),
            'author_id' => 'required|exists:authors,id',
            'genre_id' => 'required|exists:genres,id',
        ]);

        Books::create([
            'book_name' => $request->input('name'),
            'published_year' => $request->input('published_year'),
            'author_id' => $request->input('author_id'),
            'genre_id' => $request->input('genre_id'),
        ]);

        return redirect()->route('books.index')->with('success', 'Book created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $book = Books::where('id', '=', $id)->first();
        return view('books.edit', compact('book'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string',
            'published_year' => 'required|integer',
        ]);

        $book = Books::where('id', '=', $id)->first();
        $book->update($request->only(
            'name',
            'published_year',
        ));

        return redirect()->route('books.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
