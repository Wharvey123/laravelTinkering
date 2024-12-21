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
        }
        .bg-dark-red {
            background-color: darkred;
        }
        .hover-animate:hover {
            transform: scale(1.05);
            transition: transform 0.3s ease;
        }
    </style>
    <div class="max-w-lg bg-white w-full shadow-lg rounded-lg p-6 fade-in mx-auto mt-12">
        <h1 class="text-5xl text-black font-extrabold mb-6 text-center">Eliminar Pel·lícula</h1>
        <p class="text-lg text-black mb-6 text-center">
            Vols eliminar la pel·lícula "<strong>{{ $film->name }}</strong>"?
        </p>
        <form action="{{ route('films.destroy', $film->id) }}" method="POST" class="text-center">
            @csrf
            @method('DELETE')
            <button type="submit" class="bg-dark-red text-white px-6 py-3 rounded hover:bg-black hover-animate">
                Eliminar
            </button>
        </form>
        <div class="text-center mt-6">
            <a href="{{ route('films.index') }}" class="text-black hover:underline">Cancel·lar</a>
        </div>
    </div>
@endsection
