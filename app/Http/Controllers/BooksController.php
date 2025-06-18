<?php

namespace App\Http\Controllers;

use App\Http\Middleware\AuthCheck;
use App\Models\Authors;
use App\Models\Books;
use App\Models\BooksRental;
use App\Models\Genres;
use App\Models\User;
use App\RouteContract;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class BooksController extends Controller implements HasMiddleware, RouteContract
{
    /**
     * Create a new controller instance.
     *
     * This constructor applies the AuthCheck middleware to all methods in this controller,
     * ensuring that only authenticated users can access the methods.
     */
    public static function middleware(): array
    {
        return ['auth'];
    }

    public static function routes(): void
    {
        Route::prefix('books')
            ->name('books.')
            ->controller(self::class)
            ->group(function () {
                Route::resource('', BooksController::class);
                Route::get('/search', [BooksController::class, 'search'])->name('search');
                Route::post('/request/{id}', [BooksController::class, 'requestBooks'])->name('request');
                Route::get('/form/{id}', [BooksController::class, 'requestForm'])->name('form');
            });
    }

    /**
     *  Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // $books = Books::orderBy('book_name')->get();
        // return view('books.index', ['books' => $books]);
        $query = $request->input('query');

        $books = Books::query()->orderBy('book_name');

        if ($query) {
            $books->where('book_name', 'like', "%{$query}%")
                ->orWhereHas('author', function ($q) use ($query) {
                    $q->where('name', 'like', "%{$query}%");
                })
                ->orWhereHas('genre', function ($q) use ($query) {
                    $q->where('name', 'like', "%{$query}%");
                });
        }

        $books = $books->get();

        return view('books.index', compact('books', 'query'));
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

    /**
     * Show the form for requesting a book.
     *
     * @param string $id
     * @return \Illuminate\View\View
     */
    public function requestForm(string $id)
    {
        $book = Books::where('id', '=', $id)->first();
        return view('books.form', compact('book'));
    }

    /**
     * Handle the book request.
     *
     * Validates the request, checks if the book is available,
     * and creates a rental record if the book is available.
     *
     * @param \Illuminate\Http\Request $request
     * @param string $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function requestBooks(Request $request, string $id)
    {
        $request->validate([
            'days' => 'required|integer|min:1'
        ]);

        $book = Books::where('id', '=', $id)->first();
        $user = Auth::user();

        $existingRental = BooksRental::where('book_id', '=', $book->id)
            ->where('user_id',  '=', $user->id)
            ->where('rental_status', 'returned')
            ->first();

        if (empty($existingRental)) {
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
        } else {
            $existingRental->update([
                'expected_return_date' => Carbon::now()
                    ->addDays((int) $request->input('days'))
                    ->toDateString(),
                'returned_date' => null,
                'rental_status' => 'requested',
            ]);
        }

        return redirect()->route('rentals.index')->with('success', 'Book requested successfully.');
    }
}
