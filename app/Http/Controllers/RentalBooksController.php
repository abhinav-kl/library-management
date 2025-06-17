<?php

namespace App\Http\Controllers;

use App\Http\Middleware\AuthCheck;
use App\Models\Books;
use App\Models\BooksRental;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class RentalBooksController extends Controller
{
    public function __construct()
    {
        return $this->middleware(AuthCheck::class);
    }

    public function index()
    {
        $rentals = BooksRental::orderBy('created_at', 'desc')
            ->get();

        return view('rental_books.index', ['rentals' => $rentals]);
    }

    public function showRequested()
    {
        $rentals = BooksRental::where('rental_status', 'requested')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('rental_books.requested', ['rentals' => $rentals]);
    }

    public function showHolding()
    {
        $rentals = BooksRental::where('rental_status', 'holding')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('rental_books.holding', ['rentals' => $rentals]);
    }

    public function showReturned()
    {
        $rentals = BooksRental::where('rental_status', 'returned')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('rental_books.returned', ['rentals' => $rentals]);
    }

    public function approveBooks(string $id)
    {
        $rentals = BooksRental::where('rental_status', 'holding')
            ->orderBy('created_at', 'desc')
            ->get();

        $requests = BooksRental::where('id', '=', $id)
            ->where('rental_status', 'requested')
            ->first();


        if (!$requests) {
            // Optionally handle the case when the record is not found
            return redirect()->back()->with('error', 'Book rental request not found or already processed.');
        }

        $requests->update([
            'rental_status' => 'holding'
        ]);

        return view('rental_books.index', ['rentals' => $rentals]);
    }

    /**
     * now return function for the code
     */
    public function returnBooks(Request $request, string $id)
    {
        $rental = BooksRental::where('id', '=', $id)->first();
        $rental->update([
            'rental_status' => 'returned',
            'returned_date' => Carbon::now()->toDateTimeString(),
        ]);

        $book = Books::where('id', '=', $rental->book_id)->first();
        $book->update([
            'availability' => true,
        ]);

        return redirect()->route('rentals.index')->with('success', 'Book requested successfully.');
    }
}
