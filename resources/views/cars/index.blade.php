@extends('layouts.app')

@section('content')
    <div class="container mx-auto mt-8">
        <h2 class="text-3xl font-bold mb-6 text-center">Cars</h2>

        <table class="min-w-full bg-white border border-gray-300 text-black">
            <thead>
            <tr>
                <th class="px-4 py-2">Make</th>
                <th class="px-4 py-2">Model</th>
                <th class="px-4 py-2">Year</th>
                <th class="px-4 py-2">Price</th>
                <th class="px-4 py-2">Description</th>
                <th class="px-4 py-2">Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($cars as $car)
                <tr>
                    <td class="px-4 py-2">{{ $car->make }}</td>
                    <td class="px-4 py-2">{{ $car->model }}</td>
                    <td class="px-4 py-2">{{ $car->year }}</td>
                    <td class="px-4 py-2">{{ $car->price }}</td>
                    <td class="px-4 py-2">{{ $car->description }}</td>
                    <td class="px-4 py-2">
                        <a href="{{ route('cars.show', $car->id) }}" class="text-blue-500 hover:text-blue-700">View</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
