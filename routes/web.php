<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BooksController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\RentalBooksController;
use App\Http\Controllers\UsersController;
use App\Models\BooksRental;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


Route::resource('authors', AuthorController::class);
Route::resource('genres', GenreController::class);
Route::resource('users', UsersController::class);

BooksController::routes();
RentalBooksController::routes();
