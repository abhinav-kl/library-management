<?php

namespace App\Http\Controllers;

use App\Http\Middleware\AuthCheck;
use App\Models\Genres;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class GenreController extends Controller
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
        $genres = Genres::orderBy('name')->get();
        return view('genres.index', ['genres' => $genres]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('genres.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
        ]);

        Genres::create($request->only('name'));

        return redirect()->route('genres.index');
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
        $author = Genres::where('id', '=', $id)->first();
        return view('genres.edit', compact('genre'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string',
        ]);

        $author = Genres::where('id', '=', $id)->first();
        $author->update($request->only(
            'name'
        ));

        return redirect()->route('genre.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
