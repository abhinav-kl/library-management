<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BooksController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\RentalBooksController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::resource('books', BooksController::class);
Route::resource('authors', AuthorController::class);
Route::resource('genres', GenreController::class);
Route::resource('users', UsersController::class);

Route::post('/books/request/{id}', [BooksController::class, 'requestBooks'])->name('books.request');
Route::get('/books/form/{id}', [BooksController::class, 'requestForm'])->name('books.form');

Route::get('/rentals/index', [RentalBooksController::class, 'index'])->name('rentals.index');
Route::get('/rentals/requested', [RentalBooksController::class, 'showRequested'])->name('rentals.requested');
Route::get('/rentals/holding', [RentalBooksController::class, 'showHolding'])->name('rentals.holding');
Route::get('/rentals/returned', [RentalBooksController::class, 'showReturned'])->name('rentals.returned');
