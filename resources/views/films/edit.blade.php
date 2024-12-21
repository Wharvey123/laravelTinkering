@extends('layouts.app')

@section('content')
    <style>
        /* Add fade-in animation */
        .fade-in {
            animation: fadeIn ease 1s;
        }
        @keyframes fadeIn {
            0% { opacity: 0; transform: scale(0.95); }
            100% { opacity: 1; transform: scale(1); }
        }
        body {
            background-color: #111;
            color: #fff;
            overflow-x: hidden;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        tbody td {
            font-weight: bold; /* Make all table data cells bold */
        }
    </style>

    <div class="min-h-screen flex items-start justify-center fade-in pt-16 pb-16 px-4 sm:px-16">
        <div class="max-w-4xl w-full shadow-lg rounded-lg p-8 bg-white/20 backdrop-blur-md text-white mx-auto mt-8">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-5xl font-extrabold text-red-600">Edit Film</h1>
                <div>
                    <a href="/films" style="font-size: 36px;" class="text-red-600 hover:text-white">
                        <i class="fa">&#xf137;</i>
                    </a>
                </div>
            </div>

            <!-- Edit Form -->
            <form action="{{ route('films.update', $film->id) }}" method="POST">
                @csrf
                @method('PUT') <!-- Laravel PUT method for updating -->

                <!-- Film Name -->
                <div class="mb-4">
                    <label for="name" class="block font-semibold">Film Name</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $film->name) }}" required
                           class="mt-1 block w-full border border-gray-300 rounded-md p-3 text-black"
                           placeholder="Enter film name">
                </div>

                <!-- Director -->
                <div class="mb-4">
                    <label for="director" class="block font-semibold">Director</label>
                    <input type="text" id="director" name="director" value="{{ old('director', $film->director) }}" required
                           class="mt-1 block w-full border border-gray-300 rounded-md p-3 text-black"
                           placeholder="Enter director name">
                </div>

                <!-- Year -->
                <div class="mb-4">
                    <label for="year" class="block font-semibold">Year</label>
                    <input type="number" id="year" name="year" value="{{ old('year', $film->year) }}" required
                           class="mt-1 block w-full border border-gray-300 rounded-md p-3 text-black"
                           placeholder="Enter release year">
                </div>

                <!-- Description -->
                <div class="mb-4">
                    <label for="description" class="block font-semibold">Description</label>
                    <input type="text" id="description" name="description" value="{{ old('description', $film->description) }}" required
                           class="mt-1 block w-full border border-gray-300 rounded-md p-3 text-black"
                           placeholder="Enter a short description">
                </div>

                <!-- Submit Button -->
                <div class="text-center">
                    <button type="submit"
                            class="bg-red-600 text-white px-6 py-3 rounded hover:bg-white hover:text-red-600 w-full">
                        Edit Film
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
