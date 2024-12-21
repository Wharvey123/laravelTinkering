@extends('layouts.app')

@section('content')
    <style>
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
            margin-bottom: 0; /* Remove bottom margin */
        }
        tbody td {
            font-weight: bold;
        }
    </style>
    <div class="flex items-start justify-center fade-in pt-16 pb-16 px-4 sm:px-16"> <!-- Add responsive padding -->
        <div class="max-w-4xl w-full shadow-lg rounded-lg p-8 bg-white/20 backdrop-blur-md text-white">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-5xl font-extrabold text-red-600">Add New Film</h1>
                <div>
                    <a href="/films" style="font-size: 36px;" class="text-red-600 hover:text-white">
                        <i class="fa">&#xf137;</i>
                    </a>
                </div>
            </div>
            <form action="{{ route('films.store') }}" method="POST">
                @csrf
                <!-- Film Name -->
                <div class="mb-4">
                    <label for="name" class="block font-semibold">Film Name</label>
                    <input type="text" id="name" name="name" required
                           class="mt-1 block w-full border border-gray-300 rounded-md p-3 text-black"
                           placeholder="Enter film name">
                </div>
                <!-- Director -->
                <div class="mb-4">
                    <label for="director" class="block font-semibold">Director</label>
                    <input type="text" id="director" name="director" required
                           class="mt-1 block w-full border border-gray-300 rounded-md p-3 text-black"
                           placeholder="Enter director name">
                </div>
                <!-- Year -->
                <div class="mb-4">
                    <label for="year" class="block font-semibold">Year</label>
                    <input type="number" id="year" name="year" required
                           class="mt-1 block w-full border border-gray-300 rounded-md p-3 text-black"
                           placeholder="Enter release year">
                </div>
                <!-- Description -->
                <div class="mb-4">
                    <label for="description" class="block font-semibold">Description</label>
                    <textarea id="description" name="description" required
                              class="mt-1 block w-full border border-gray-300 rounded-md p-3 text-black"
                              placeholder="Enter a short description (max 255 characters)"></textarea>
                </div>
                <!-- Submit Button -->
                <div class="text-center">
                    <button type="submit"
                            class="bg-red-600 text-white px-6 py-3 rounded hover:bg-white hover:text-red-600 w-full">
                        Save Film
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
