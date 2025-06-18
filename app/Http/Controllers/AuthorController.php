<?php

namespace App\Http\Controllers;

use App\Http\Middleware\AuthCheck;
use App\Models\Authors;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use PharIo\Manifest\Author;

class AuthorController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            'auth',
        ];
    }

    /**
     * Create a new controller instance.
     *
     * This constructor applies the AuthCheck middleware to all methods in this controller,
     * ensuring that only authenticated users can access the author management features.
     */
    public function __construct() {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $authors = Authors::orderBy('name')->get();
        return view('authors.index', ['authors' => $authors]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('authors.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
        ]);

        Authors::create($request->only('name'));

        return redirect()->route('authors.index');
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
    public function edit(Author $author)
    {
        return view('authors.edit', compact('author'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string',
        ]);

        $author = Authors::where('id', '=', $id)->first();
        $author->update($request->only(
            'name'
        ));

        return redirect()->route('authors.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
