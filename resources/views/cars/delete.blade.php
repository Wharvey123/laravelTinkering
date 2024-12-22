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
        .bg-dark-red {
            background-color: darkred;
        }
        .hover-animate:hover {
            transform: scale(1.05);
            transition: transform 0.3s ease;
        }
    </style>

    <div class="min-h-screen flex items-start justify-center fade-in pt-16 pb-16 px-4 sm:px-8 md:px-16">
        <div class="max-w-lg w-full shadow-lg rounded-lg p-6 bg-white text-black mx-auto mt-8">
            <h1 class="text-5xl text-black font-extrabold mb-6 text-center">Eliminar Cotxe</h1>
            <p class="text-lg text-black mb-6 text-center">
                Vols eliminar el cotxe "<strong>{{ $car->make }} {{ $car->model }}</strong>"?
            </p>
            <form action="{{ route('cars.destroy', $car->id) }}" method="POST" class="text-center">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-dark-red text-white px-6 py-3 rounded hover:bg-black hover-animate w-full">
                    Eliminar
                </button>
            </form>
            <div class="text-center mt-6">
                <a href="{{ route('cars.index') }}" class="text-black hover:underline">Cancel·lar</a>
            </div>
        </div>
    </div>
@endsection
