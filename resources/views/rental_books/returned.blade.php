@extends('layout')

@section('content')

<div class="max-w-4xl mx-auto p-6 space-y-6">
    <h3 class="text-2xl font-semibold text-gray-800">Rental Books</h3>
    @foreach ($rentals as $rental)
        <div class="bg-white shadow-md rounded-lg p-6 hover:shadow-lg transition-shadow duration-300">

            <div class="flex justify-between items-center mb-4">
                <h3 class="text-2xl font-semibold text-gray-800">{{ $rental->book->book_name }}</h3>
            </div>
            <p class="text-gray-600"><span class="font-semibold">Author:</span> {{ $rental->user->name }}</p>
            <p class="text-gray-600"><span class="font-semibold">Author:</span> {{ $rental->book->author->name }}</p>
            <p class="text-gray-600"><span class="font-semibold">Genre:</span> {{ $rental->book->genre->name }}</p>
            <p class="text-gray-600"><span class="font-semibold">Rented Date</span> {{ $rental->created_at }}</p>
            <p class="text-gray-600"><span class="font-semibold">Expected Return Date</span> {{ $rental->expected_return_date }}</p>
            <p class="text-gray-600"><span class="font-semibold">Returned Date</span> {{ $rental->returned_date }}</p>
        </div>
    @endforeach
</div>

@endsection
