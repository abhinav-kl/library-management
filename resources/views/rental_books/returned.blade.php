@extends('layout')

@section('content')

<div class="max-w-4xl mx-auto p-6 space-y-6">
    <h3 class="text-2xl font-semibold text-gray-800">Rental Books</h3>
    <br>
    <a href="{{ route('rentals.index') }}"
        class="bg-indigo-900 text-white px-5 py-2.5 rounded-full text-sm hover:bg-indigo-700 transition shadow-sm">
        📚 Back
    </a>
    @foreach ($rentals as $rental)
        <div class="bg-white shadow-md rounded-lg p-6 hover:shadow-lg transition-shadow duration-300">

            <div class="flex justify-between items-center mb-4">
                <h3 class="text-2xl font-semibold text-gray-800">{{ $rental->books->book_name }}</h3>
            </div>
            <p class="text-gray-600"><span class="font-semibold">Requested User :</span> {{ $rental->user->name }}</p>
            <p class="text-gray-600"><span class="font-semibold">Author : </span> {{ $rental->books->author->name }}</p>
            <p class="text-gray-600"><span class="font-semibold">Genre : </span> {{ $rental->books->genre->name }}</p>
            <p class="text-gray-600"><span class="font-semibold">Rented Date : </span> {{ $rental->created_at }}</p>
            <p class="text-gray-600"><span class="font-semibold">Expected Return Date : </span> {{ $rental->expected_return_date }}</p>
            <p class="text-gray-600"><span class="font-semibold">Status : </span> {{ $rental->rental_status }}</p>
            <p class="text-gray-600"><span class="font-semibold">Returned Date : </span> {{ $rental->returned_date }}</p>
        </div>
    @endforeach
</div>

@endsection
