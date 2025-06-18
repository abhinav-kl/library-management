<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return response()->json(['user' => $request->user()]);
})->middleware('auth.sanctum');


Route::get('/hello', function (Request $request) {
    return response()->json([
        'message' => 'Hello World!.',
        'user' => 'Johan',
    ]);
});
