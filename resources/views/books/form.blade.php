@extends('layout')

@section('title', 'Request Book')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-100 py-10 px-4">
    <div class="w-full max-w-md bg-white p-8 rounded shadow-md">
        <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Request Book</h2>

        {{-- Success Message --}}
        @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 border border-green-300 text-green-800 rounded">
                {{ session('success') }}
            </div>
        @endif

        {{-- Validation Errors --}}
        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-100 border border-red-300 text-red-800 rounded">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('books.request', $book->id) }}" method="POST" class="space-y-5">
            @csrf

             {{-- Book Info --}}

            <p class="text-gray-600"><span class="font-semibold">Book:</span> {{ $book->book_name }}</p>
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

            {{-- --}}

            @if ($book->availability == true)
                <div>
                    <label for="days" class="block text-sm font-medium text-gray-700">Days for Renting.</label>
                    <input type="text" name="days" id="days" value="{{ old('days') }}"
                        class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>

                <div class="text-center">
                    <button type="submit"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-6 rounded-md transition duration-200">
                        Request Book Rental
                    </button>
                </div>
            @endif

        </form>
    </div>
</div>
@endsection
