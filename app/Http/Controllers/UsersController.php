<?php

namespace App\Http\Controllers;

use App\Http\Middleware\AuthCheck;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class UsersController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * This constructor applies the AuthCheck middleware to all methods in this controller,
     * ensuring that only authenticated users can access the user management features.
     */
    public function __construct()
    {
        return $this->middleware(AuthCheck::class);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::where('user_type', '!=', 'ADM')->orderBy('name')->get();
        return view('users.index', ['users' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required',
            'username' => 'required|string',
            'password' => 'required',
        ]);

        User::create($request->only(
            'name',
            'email',
            'username',
            'password',
        ));

        return redirect()->route('books.index');
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
