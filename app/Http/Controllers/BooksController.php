<?php

namespace App\Http\Controllers;

use App\Http\Middleware\AuthCheck;
use App\Models\Authors;
use App\Models\Books;
use App\Models\BooksRental;
use App\Models\Genres;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

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

    public function requestForm(string $id)
    {
        $book = Books::where('id', '=', $id)->first();
        return view('books.form', compact('book'));
    }

    public function requestBooks(Request $request, string $id)
    {
        $request->validate([
            'days' => 'required|integer|min:1'
        ]);

        $book = Books::where('id', '=', $id)->first();
        $user = Auth::user();

        BooksRental::firstOrCreate(
            [
                'book_id' => $book->id,
                'user_id' => $user->id,
            ],
            [
                'expected_return_date' => Carbon::now()
                    ->addDays((int) $request->input('days'))
                    ->toDateString(),
                'returned_date' => null,
                'rental_status' => 'requested',
            ]
        );

        Books::update([
            'availability' => false,
        ]);

        return redirect()->route('rentals.requested')->with('success', 'Book requested successfully.');
    }

    /**
     * now return function for the code
     */
    public function returnForm(string $id)
    {
        $book = Books::where('id', '=', $id)->first();
        return view('books.form', compact('book'));
    }

    public function returnBooks(Request $request, string $id)
    {
        $rental = BooksRental::where('id', '=', $id)->first();
        $rental->update([
            'returned_date' => Carbon::now()->toString(),
        ]);

        Books::update([
            'availability' => true,
        ]);

        return redirect()->route('rentals.requested')->with('success', 'Book requested successfully.');
    }
}
