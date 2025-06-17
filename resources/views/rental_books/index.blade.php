@extends('layout')

@section('content')

<div class="max-w-4xl mx-auto p-6 space-y-6">
 <h3 class="text-2xl font-semibold text-gray-800 mb-4">Rental Books</h3>

    @if (Auth::user()->user_type === 'ADM')
        <div class="flex flex-wrap gap-3 mb-6">
            <a href="{{ route('rentals.holding') }}"
            class="bg-indigo-900 text-white px-5 py-2.5 rounded-full text-sm hover:bg-indigo-700 transition shadow-sm">
                📚 Rented Books
            </a>

            <a href="{{ route('rentals.requested') }}"
            class="bg-indigo-900 text-white px-5 py-2.5 rounded-full text-sm hover:bg-indigo-700 transition shadow-sm">
                📝 Book Requests
            </a>

            <a href="{{ route('rentals.returned') }}"
            class="bg-indigo-900 text-white px-5 py-2.5 rounded-full text-sm hover:bg-indigo-700 transition shadow-sm">
                ✅ Returned Books
            </a>
        </div>
    @endif

    @foreach ($rentals as $rental)
        <div class="bg-white shadow-md rounded-lg p-6 hover:shadow-lg transition-shadow duration-300">

            <div class="flex justify-between items-center mb-4">
                <h3 class="text-2xl font-semibold text-gray-800">{{ $rental->books->book_name }}</h3>
            </div>
            @if (Auth::user()->user_type === 'ADM' & $rental->user_id !== Auth::user()->id)
                <p class="text-gray-600"><span class="font-semibold">Requested User:</span> {{ $rental->user->name }}</p>
                <p class="text-gray-600"><span class="font-semibold">Author:</span> {{ $rental->books->author->name }}</p>
                <p class="text-gray-600"><span class="font-semibold">Genre:</span> {{ $rental->books->genre->name }}</p>
                <p class="text-gray-600"><span class="font-semibold">Rented Date : </span> {{ $rental->created_at }}</p>
                <p class="text-gray-600"><span class="font-semibold">Expected Return Date : </span> {{ $rental->expected_return_date }}</p>
                <p class="text-gray-600"><span class="font-semibold">Status : </span> {{ $rental->rental_status }}</p>
                @if ($rental->returned_date !== null)
                    <p class="text-gray-600"><span class="font-semibold">Returned Date</span> {{ $rental->returned_date }}</p>
                @endif
            @else
                <p class="text-gray-600"><span class="font-semibold">Author:</span> {{ $rental->books->author->name }}</p>
                <p class="text-gray-600"><span class="font-semibold">Genre:</span> {{ $rental->books->genre->name }}</p>
                <p class="text-gray-600"><span class="font-semibold">Rented Date : </span> {{ $rental->created_at }}</p>
                <p class="text-gray-600"><span class="font-semibold">Expected Return Date : </span> {{ $rental->expected_return_date }}</p>
                @if ($rental->rental_status === 'requested')
                    <p class="text-blue-600"><span class="font-semibold">Status : </span> {{ $rental->rental_status }}</p>
                @elseif ($rental->rental_status === 'holding')
                    <p class="text-yellow-600"><span class="font-semibold">Status : </span> {{ $rental->rental_status }}</p>
                @else
                    <p class="text-green-600"><span class="font-semibold">Status : </span> {{ $rental->rental_status }}</p>
                @endif
                @if ($rental->returned_date !== null)
                    <p class="text-gray-600"><span class="font-semibold">Returned Date</span> {{ $rental->returned_date }}</p>
                @endif
            @endif
            <br>

            @if (Auth::user()->user_type === 'ADM')
                @if ($rental->rental_status === 'requested')
                    <div class="flex justify-center gap-4 mt-4">
                        {{-- Approve Button --}}
                        <form action="{{ route('books.approve', $rental->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <button type="submit"
                                class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-6 rounded-md transition duration-200 shadow-sm">
                                ✅ Approve
                            </button>
                        </form>

                        {{-- Reject Button --}}
                        <form action="{{ route('books.reject', $rental->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <button type="submit"
                                class="bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-6 rounded-md transition duration-200 shadow-sm">
                                ❌ Reject
                            </button>
                        </form>
                    </div>
                @endif
            @else
                @if ($rental->rental_status === 'holding')
                    <form action="{{ route('books.return', $rental->id) }}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="text-center">
                            <button type="submit"
                                class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-6 rounded-md transition duration-200">
                                Return Book
                            </button>
                        </div>
                    </form>
                @endif
            @endif

        </div>
    @endforeach
</div>

@endsection
