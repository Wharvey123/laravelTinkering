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
                <h1 class="text-5xl font-extrabold text-red-600">Edit Car</h1>
                <div>
                    <a href="/cars" style="font-size: 36px;" class="text-red-600 hover:text-white">
                        <i class="fa">&#xf137;</i>
                    </a>
                </div>
            </div>

            <!-- Edit Form -->
            <form action="{{ route('cars.update', $car->id) }}" method="POST">
                @csrf
                @method('PUT') <!-- Laravel PUT method for updating -->

                <!-- Make -->
                <div class="mb-4">
                    <label for="make" class="block font-semibold">Make</label>
                    <input type="text" id="make" name="make" value="{{ old('make', $car->make) }}" required
                           class="mt-1 block w-full border border-gray-300 rounded-md p-3 text-black"
                           placeholder="Enter car make">
                </div>

                <!-- Model -->
                <div class="mb-4">
                    <label for="model" class="block font-semibold">Model</label>
                    <input type="text" id="model" name="model" value="{{ old('model', $car->model) }}" required
                           class="mt-1 block w-full border border-gray-300 rounded-md p-3 text-black"
                           placeholder="Enter car model">
                </div>

                <!-- Year -->
                <div class="mb-4">
                    <label for="year" class="block font-semibold">Year</label>
                    <input type="number" id="year" name="year" value="{{ old('year', $car->year) }}" required
                           class="mt-1 block w-full border border-gray-300 rounded-md p-3 text-black"
                           placeholder="Enter manufacture year">
                </div>

                <!-- Price -->
                <div class="mb-4">
                    <label for="price" class="block font-semibold">Price (€)</label>
                    <input type="number" id="price" name="price" value="{{ old('price', $car->price) }}" required
                           step="0.01"
                           class="mt-1 block w-full border border-gray-300 rounded-md p-3 text-black"
                           placeholder="Enter car price in euros">
                </div>

                <!-- Submit Button -->
                <div class="text-center">
                    <button type="submit"
                            class="bg-red-600 text-white px-6 py-3 rounded hover:bg-white hover:text-red-600 w-full">
                        Edit Car
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
