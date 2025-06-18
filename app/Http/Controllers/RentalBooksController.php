<?php

namespace App\Http\Controllers;

use App\Http\Middleware\AuthCheck;
use App\Models\Books;
use App\Models\BooksRental;
use App\RouteContract;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Facades\Route;
use Symfony\Component\CssSelector\Node\FunctionNode;

class RentalBooksController extends Controller implements HasMiddleware, RouteContract
{
    public static function middleware(): array
    {
        return ['auth'];
    }

    public static function routes(): void
    {
        Route::prefix('rentals')
            ->controller(self::class)
            ->group(function () {
                Route::get('/index', [RentalBooksController::class, 'index'])->name('rentals.index');
                Route::get('/requested', [RentalBooksController::class, 'showRequested'])->name('rentals.requested');
                Route::get('/holding', [RentalBooksController::class, 'showHolding'])->name('rentals.holding');
                Route::get('/returned', [RentalBooksController::class, 'showReturned'])->name('rentals.returned');
                Route::put('/return/{id}', [RentalBooksController::class, 'returnBooks'])->name('rentals.return');
                Route::put('/approve/{id}', [RentalBooksController::class, 'approveBooks'])->name('rentals.approve');
                Route::put('/reject/{id}', [RentalBooksController::class, 'rejectBooks'])->name('rentals.reject');
            });
    }
    /**
     * Display a listing of the resource.
     *
     * This method retrieves all book rentals ordered by their creation date in descending order
     * and returns them to the rental_books.index view.
     */
    public function index()
    {
        $rentals = BooksRental::orderBy('created_at', 'desc')
            ->get();

        return view('rental_books.index', ['rentals' => $rentals]);
    }

    /**
     * Show the list of requested books.
     *
     * This method retrieves all book rentals that are currently requested,
     * ordered by their creation date in descending order, and returns them
     * to the rental_books.requested view.
     */
    public function showRequested()
    {
        $rentals = BooksRental::where('rental_status', 'requested')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('rental_books.requested', ['rentals' => $rentals]);
    }

    /**
     * Show the list of books that are currently on hold.
     *
     * This method retrieves all book rentals that are currently on hold,
     * ordered by their creation date in descending order, and returns them
     * to the rental_books.holding view.
     */
    public function showHolding()
    {
        $rentals = BooksRental::where('rental_status', 'holding')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('rental_books.holding', ['rentals' => $rentals]);
    }

    /**
     * Show the list of returned books.
     *
     * This method retrieves all book rentals that have been returned,
     * ordered by their creation date in descending order, and returns them
     * to the rental_books.returned view.
     */
    public function showReturned()
    {
        $rentals = BooksRental::where('rental_status', 'returned')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('rental_books.returned', ['rentals' => $rentals]);
    }

    /**
     * Approve a book rental request.
     *
     * This method retrieves all book rentals that are currently on hold,
     * and updates the status of a specific rental request to 'holding'.
     * It then returns the updated list of rentals to the rental_books.index view.
     *
     * @param string $id The ID of the rental request to approve.
     */
    // This method is used to approve a book rental request.
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

        $books = Books::where('id', '=', $requests->book_id)->first();
        $books->update([
            'availability' => false,
        ]);

        $requests->update([
            'rental_status' => 'holding'
        ]);

        BooksRental::where('id', '!=', $id)
            ->where('book_id', $requests->book_id)
            ->delete();

        return view('rental_books.index', ['rentals' => $rentals]);
    }

    public function rejectBooks(string $id)
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

        $books = Books::where('id', '=', $requests->book_id)->first();
        $books->update([
            'availability' => true,
        ]);

        $requests->delete();

        return view('rental_books.index', ['rentals' => $rentals]);
    }

    /**
     * Reject a book rental request.
     *
     * This method retrieves all book rentals that are currently requested,
     * and updates the status of a specific rental request to 'rejected'.
     * It then returns the updated list of rentals to the rental_books.index view.
     *
     * @param string $id The ID of the rental request to reject.
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

        return redirect()->route('rentals.index')->with('success', 'Book returned successfully.');
    }
}
