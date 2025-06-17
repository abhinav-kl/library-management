@extends('layout')

@section('content')

<div class="max-w-4xl mx-auto p-6 space-y-6">
    <h1 class="text-2xl font-semibold text-gray-800">Users</h1>
    @foreach ($users as $user)
        <div class="bg-white shadow-md rounded-lg p-6 hover:shadow-lg transition-shadow duration-300">

            {{-- Title and Edit Button --}}
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-2xl font-semibold text-gray-800">{{ $user->username }}</h3>
                <a href="{{ route('users.edit', $user->id) }}"
                   class="bg-indigo-600 text-white px-4 py-2 rounded-full text-sm hover:bg-indigo-700 transition">
                    Edit
                </a>
            </div>

            {{-- Book Info --}}
            <p class="text-gray-600"><span class="font-semibold">Author:</span> {{ $user->name }}</p>
            <p class="text-gray-600"><span class="font-semibold">Genre:</span> {{ $user->email }}</p>
        </div>
    @endforeach
</div>

@endsection
