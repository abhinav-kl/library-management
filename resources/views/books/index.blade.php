@extends('layout')

@section('content')

<div class="max-w-4xl mx-auto p-6 space-y-6">
    <div class="flex justify-between items-center mb-4">
        @if (Auth::user()->user_type === 'ADM')
            <a href="{{ route('books.create') }}"
                class="bg-indigo-900 text-white px-4 py-2 rounded-full text-sm hover:bg-indigo-700 transition">
                Add Books
            </a>
        @else
            <form action="{{ route('books.index') }}" method="GET" class="w-full">
                <div class="flex items-center space-x-2">
                    <input type="text" name="query" placeholder="Search books..."
                        value="{{ request('query') }}"
                        class="border border-gray-300 rounded-md px-4 py-2 w-full" required>
                    <button type="submit"
                            class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded-md transition duration-200">
                        Search
                    </button>
                </div>
            </form>
        @endif
    </div>

    <h3 class="text-2xl font-semibold text-gray-800">Books</h3>

    @if(request()->has('query'))
        <p class="text-sm text-gray-500">Showing results for: <strong>{{ request('query') }}</strong></p>
    @endif

    @forelse ($books as $book)
        <div class="bg-white shadow-md rounded-lg p-6 hover:shadow-lg transition-shadow duration-300">

            {{-- Title and Action Button --}}
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-2xl font-semibold text-gray-800">{{ $book->book_name }}</h3>
                @if (Auth::user()->user_type === 'ADM')
                    <a href="{{ route('books.edit', $book->id) }}"
                       class="bg-indigo-600 text-white px-4 py-2 rounded-full text-sm hover:bg-indigo-700 transition">
                        Edit
                    </a>
                @else
                    @if ($book->availability == true)
                        <a href="{{ route('books.form', $book->id) }}"
                        class="bg-indigo-600 text-white px-4 py-2 rounded-full text-sm hover:bg-indigo-700 transition">
                            Rental Request
                        </a>
                    @endif
                @endif
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
    @empty
        <p class="text-red-500">No books found.</p>
    @endforelse
</div>

@endsection
