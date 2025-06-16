@extends('layout')

@section('content')

<div class="max-w-4xl mx-auto p-6 space-y-6">
    <div class="flex justify-between items-center mb-4">
        <a href="{{ route('books.create') }}"
            class="bg-indigo-900 text-white px-4 py-2 rounded-full text-sm hover:bg-indigo-700 transition">
            Add Books
        </a>
    </div>
    @foreach ($books as $book)
        <div class="bg-white shadow-md rounded-lg p-6 hover:shadow-lg transition-shadow duration-300">

            {{-- Title and Edit Button --}}
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-2xl font-semibold text-gray-800">{{ $book->book_name }}</h3>
                <a href="{{ route('books.edit', $book->id) }}"
                   class="bg-indigo-600 text-white px-4 py-2 rounded-full text-sm hover:bg-indigo-700 transition">
                    Edit
                </a>
            </div>

            {{-- Book Info --}}
            <p class="text-gray-600"><span class="font-semibold">Author:</span> {{ $book->author->name }}</p>
            <p class="text-gray-600"><span class="font-semibold">Genre:</span> {{ $book->genre->name }}</p>
            <p class="text-gray-600">
                <span class="font-semibold">Availability:</span>
                @if ($book->availability)
                    <span class="text-green-600 font-bold">Available</span>
                @else
                    <span class="text-red-600 font-bold">Unavailable</span>
                @endif
            </p>
            <p class="text-gray-600"><span class="font-semibold">Published:</span> {{ $book->published_year }}</p>
        </div>
    @endforeach
</div>

@endsection
