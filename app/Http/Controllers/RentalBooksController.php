<?php

namespace App\Http\Controllers;

use App\Http\Middleware\AuthCheck;
use App\Models\BooksRental;
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
}
