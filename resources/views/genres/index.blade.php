@extends('layout')

@section('content')

<div class="max-w-4xl mx-auto p-6 space-y-6">
    <div class="flex justify-between items-center mb-4">
        <a href="{{ route('genres.create') }}"
            class="bg-indigo-900 text-white px-4 py-2 rounded-full text-sm hover:bg-indigo-700 transition">
            Add Genres
        </a>
    </div>
    @foreach ($genres as $genre)
        <div class="bg-white shadow-md rounded-lg p-6 hover:shadow-lg transition-shadow duration-300">

            {{-- Title and Edit Button --}}
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-2xl font-semibold text-gray-800">{{ $genre->name }}</h3>
                <a href="{{ route('genres.edit', $genre->id) }}"
                   class="bg-indigo-600 text-white px-4 py-2 rounded-full text-sm hover:bg-indigo-700 transition">
                    Edit
                </a>
            </div>
        </div>
    @endforeach
</div>

@endsection
